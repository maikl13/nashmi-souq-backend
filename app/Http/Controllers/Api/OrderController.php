<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PackagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\PackageStatusUpdate;
use App\Models\Product;
use App\Models\Transaction;
use Auth;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($store)
    {
        $orders = auth()->user()->orders()->latest()->paginate(12);
        // Order::with('user','state','transaction','packages')->latest()->paginate(12);
        return response()->json($orders->load('transaction', 'state', 'packages'));
    }

    public function show(Order $order)
    {
        //$this->authorize('view', $order);
        // $order->with('user','store','transaction','packages');
        return response()->json($order->load('user', 'transaction', 'store', 'packages'));
    }

    public function store($store, Request $request, $code)
    {
        $user = Auth::user();
        $country = Country::where('code', $code)->first();

        $allowed_payment_methods = [];

        if ($store->store_online_payments) {
            $allowed_payment_methods = [Order::CREDIT_PAYMENT, Order::PAYPAL_PAYMENT, Order::MADA_PAYMENT];
        }

        if ($store->store_cod_payments) {
            $allowed_payment_methods[] = Order::ON_DELIVERY_PAYMENT;
        }

        $request->validate([
            'name' => 'required|max:255',
            'state' => 'required|exists:states,id',
            'phone' => 'required|max:16',
            'address' => 'required|max:255',
            'payment_method' => 'required|in:'.implode(',', $allowed_payment_methods),
            'note' => 'nullable|max:10000',
        ]);

        $items = Cart::where('store_id', $store->id)
        ->where('user_id', $user->id)
        ->get();

        $total_price = DB::table('carts')
          ->where('carts.store_id', $store->id)
          ->where('carts.user_id', $user->id)
          ->join('products', 'products.id', '=', 'carts.product_id')
          ->select(DB::raw('SUM(carts.quantity * products.price) as total_price'))
          ->get();

        if (! count($items)) {
            return response()->json(['failure', 'من فضلك قم بإضافة منتجات لعربة التسوق أولا !']);
        }

        $order = new Order;

        // order info
        $order->uid = unique_id();
        $order->payment_method = $request->payment_method;
        $order->status = $order->payment_method == Order::ON_DELIVERY_PAYMENT ? Order::STATUS_PROCESSING : Order::STATUS_UNPAID;
        $order->price = $total_price;
        $order->store_id = $store->id;

        // buyer info
        $order->user_id = auth()->user()->id;
        $order->buyer_name = $request->name;
        $order->state_id = $request->state;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->currency_id = $country->currency_id;
        //  dd($items);
        if ($order->save()) {
            foreach ($items as $id => $item) {
                $product = Product::findOrFail($item->product_id);

                // Save Package
                $package = Package::where('order_id', $order->id)->where('store_id', $product->user->id)->first();
                if (! $package) {
                    $package = new Package;
                    $package->uid = uniqid();
                }
                $package->order_id = $order->id;
                $package->store_id = $product->user->id;
                $package->save();

                // Save Package Item
                $package_item = new PackageItem;
                // product info
                $package_item->package_id = $package->id;
                $package_item->product_id = $product->id;
                $package_item->title = $product->title;
                $package_item->quantity = $item->quantity;
                $package_item->price = $product->price;
                $package_item->original_price = $product->price;
                $package_item->original_currency_id = $product->currency->id;
                $package_item->save();
            }

            $user = auth()->user();
            $user->shipping_address = $order->address;
            $user->state_id = $request->state;
            $user->save();

            if ($request->payment_method == Order::ON_DELIVERY_PAYMENT) {
                Cart::where('user_id', $user->id)->where('store_id', $store->id)->delete();

                return response()->json(['message' => 'Order saved successfully.',
                    'order-saved', $store->store_slug], 201);
            } else {
                $price = $order->price();
                switch ($request->payment_method) {
                    case Order::PAYPAL_PAYMENT: $payment_method = Transaction::PAYMENT_PAYPAL;
                    break;
                    case Order::MADA_PAYMENT: $payment_method = Transaction::PAYMENT_MADA;
                    break;
                    default: $payment_method = Transaction::PAYMENT_DIRECT_PAYMENT;
                    break;
                }
                $transaction = Transaction::payment_init($price, $order->currency, ['payment_method' => $payment_method]);
                if ($transaction) {
                    $order->transaction_id = $transaction->id;
                    if ($order->save()) {
                        if ($request->payment_method == Order::PAYPAL_PAYMENT) {
                            $transaction_items = [[
                                'name' => 'مدفوعات لسوق نشمي لشراء منتجات',
                                'price' => ceil($transaction->amount_usd),
                                'desc' => 'مدفوعات لسوق نشمي لشراء منتجات',
                                'qty' => 1,
                            ]];
                            $transaction->items = $transaction_items;
                            $transaction->save();
                            Cart::where('user_id', $user->id)->where('store_id', $store->id)->delete();

                            return response()->json(['transaction_paypal_payment' => $transaction->paypal_payment()]);
                        }

                        return $transaction->direct_payment([
                            'description' => 'store subscription',
                        ]);
                    }
                }
            }
        }

        return response()->json(['failure', 'حدث خطأ ما من فضلك حاول مجددا!']);
    }

    public function order_saved()
    {
        $cart = new Cart;
        $cart->clear();

        return response()->json([
            'message' => 'طلبك قيد المراجعة',
            'message1' => 'سيتم مراجعة طلبك, و سيم إعلامك بمجرد قبول الطلب!',
            'cart' => $cart,
            'info' => 'يمكنك تتبع حالة الطلب من الرابط التالي:',
            'link' => url('api/my-orders'),
            'request_store_slug' => request()->store->store_slug,

        ]);
    }

    public function cancel_order($store, Package $package)
    {
        $this->authorize('cancel', $package);
        $package->status = Package::STATUS_CANCELLED;

        if ($package->save()) {
            $package_status_update = new PackageStatusUpdate;
            $package_status_update->status = $package->status;
            $package_status_update->package_id = $package->id;
            $package_status_update->user_id = auth()->user()->id;
            $package_status_update->save();
        }

        return response()->json(['message' => 'canceld order successfully', 'redirect to' => url('/order/'.$package->order->id.'/details')]);
    }

    // =======================================================
    // For Stores
    // =======================================================

    public function orders(PackagesDataTable $dataTable)
    {
        return $dataTable->render('store-dashboard.orders');
    }

    public function show_for_store($store, Package $package)
    {
        $this->authorize('show_for_store', $package);

        return view('store-dashboard.order')->with([
            'order' => $package->order,
            'package' => $package,
        ]);
    }

    public function change_status(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $this->authorize('change_status', $package);

        if ($package->is_pending()) {
            if ($request->package_status == 'approved') {
                $package->status = Package::STATUS_APPROVED;
            } elseif ($request->package_status == 'rejected') {
                if ($request->rejection_type == 2) {
                    $package->status = Package::STATUS_SOFT_REJECTED;
                } else {
                    $package->status = Package::STATUS_HARD_REJECTED;
                }
            }
        } elseif ($package->is_deliverable()) {
            if ($request->package_status == 'prepared') {
                $package->status = Package::STATUS_PREPARED;
            } elseif ($request->package_status == 'cancelled') {
                $package->status = package::STATUS_CANCELLED;
            }
        } else {
            if ($request->package_status == 'backward') {
                if ($package->is_approved() || $package->is_rejected()) {
                    $package->status = Package::STATUS_PENDING;
                } elseif ($package->is_prepared()) {
                    $package->status = Package::STATUS_DELIVERABLE;
                } elseif ($package->is_cancelled()) {
                    $status_before_cancelling = $package->package_status_updates()->latest()->offset(1)->first();
                    if ($package->is_cancelled_by_buyer() && auth()->user()->id == $package->user_id) {
                        $package->status = $status_before_cancelling ? $status_before_cancelling->status : Package::STATUS_PENDING;
                    } elseif (! $package->is_cancelled_by_buyer() && auth()->user()->id == $package->store_id) {
                        $package->status = $status_before_cancelling ? $status_before_cancelling->status : Package::STATUS_PENDING;
                    }
                } elseif ($package->is_delivered()) {
                    $package->status = Package::STATUS_PREPARED;
                }
            } elseif ($request->package_status == 'forward') {
                if ($package->is_approved()) {
                    $package->status = Package::STATUS_DELIVERABLE;
                } elseif ($package->is_rejected()) {
                    $package->status = Package::STATUS_DELIVERABLE;
                } elseif ($package->is_prepared()) {
                    $package->status = Package::STATUS_DELIVERED;
                } elseif ($package->is_cancelled()) {
                    $status_before_cancelling = $package->package_status_updates()->latest()->offset(1)->first();
                    $package->status = $status_before_cancelling ? $status_before_cancelling->status : Package::STATUS_PENDING;
                    switch ($package->status) {
                        case Package::STATUS_PENDING: $package->status = Package::STATUS_APPROVED;
                        break;
                        case Package::STATUS_APPROVED: $package->status = Package::STATUS_DELIVERABLE;
                        break;
                        case Package::STATUS_DELIVERABLE: $package->status = Package::STATUS_PREPARED;
                        break;
                        default: $package->status = Package::STATUS_APPROVED;
                        break;
                    }
                }
            }
        }

        if ($package->save()) {
            $package_status_update = new PackageStatusUpdate;
            $package_status_update->status = $package->status;
            $package_status_update->package_id = $package->id;
            $package_status_update->user_id = auth()->user()->id;
            $package_status_update->note = $request->note ?? null;
            if ($package_status_update->save()) {
                if ($request->ajax()) {
                    return response()->json(view('store.partials.change-status-options')->with('package', $package)->render(), 200);
                }

                return redirect()->back();
            }
        }

        return response()->json('ليست لديك الصلاحيات لإجراء هذا التغيير', 403);
    }

    public function get_shipping(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $this->authorize('show_for_store', $package);
        // return $package->shipping ?? '-';
        return '-';
    }

    public function get_status(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $this->authorize('show_for_store', $package);

        return $package->status();
    }

    public function get_status_updates_log(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $this->authorize('show_for_store', $package);

        return response()->json(view('store.partials.package-status-updates')->with('package', $package)->render(), 200);
    }
}
