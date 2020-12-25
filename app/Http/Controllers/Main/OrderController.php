<?php

namespace App\Http\Controllers\Main;

use App\Models\Order;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Transaction;
use App\Models\PackageStatusUpdate;
use App\Models\Cart;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\DataTables\PackagesDataTable;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('store.buyer.my-orders')->with('orders', auth()->user()->orders()->latest()->paginate(12));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('store.buyer.order')->with('order', $order);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'state' => 'required|exists:states,id',
            'phone' => 'required|max:16',
            'address' => 'required|max:255',
            'payment_method' => 'required|in:'.Order::CREDIT_PAYMENT.','.Order::ON_DELIVERY_PAYMENT,
            'note' => 'nullable|max:10000',
        ]);

        $cart = new Cart;
        $items = $cart->items();

        if(!sizeof($items))
            return redirect()->back()->with('failure', 'Please Add some products to your shopping cart first');

        $order = new Order;
    
        // order info
        $order->uid = unique_id();
        $order->payment_method = $request->payment_method;
        $order->status = $order->payment_method == Order::CREDIT_PAYMENT ? Order::STATUS_UNPAID : Order::STATUS_PROCESSING;
        $order->price = $cart->total_price();

        // buyer info
        $order->user_id = auth()->user()->id;
        $order->buyer_name = $request->name;
        $order->state_id = $request->state;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->currency_id = country()->currency_id;

        if($order->save()){
            foreach($items as $id => $item){
                $listing = Listing::findOrFail($id);
                
                // Save Package
                $package = Package::where('order_id', $order->id)->where('store_id', $listing->user->id)->first();
                if(!$package){
                    $package = new Package;
                    $package->uid = uniqid();
                }
                $package->order_id = $order->id;
                $package->store_id = $listing->user->id;
                $package->save();

                // Save Package Item
                $package_item = new PackageItem;
                // product info
                $package_item->package_id = $package->id;
                $package_item->listing_id = $listing->id;
                $package_item->title = $item['title'];
                $package_item->quantity = $item['quantity'];
                $package_item->price = $item['price'];
                $package_item->original_price = $listing->price;
                $package_item->original_currency_id = $listing->currency->id;
                $package_item->save();
            }
            
            $user = auth()->user();
            $user->shipping_address = $order->address;
            $user->state_id = $request->state;
            $user->save();

            if($request->payment_method == Order::CREDIT_PAYMENT){
                $price = $order->price();
                $transaction = Transaction::payment_init($price, $order->currency);
                if($transaction){
                    $order->transaction_id = $transaction->id;
                    if($order->save())
                        return $transaction->direct_payment();
                }
            } else {
                return redirect()->route('order-saved');
            }
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما من فضلك حاول مجددا!');
    }

    public function order_saved()
    {
        $cart = new Cart;
        $cart->clear();
        return view('store.buyer.order-saved');
    }

    public function cancel_order(Package $package)
    {
        $this->authorize('cancel', $package);
        $package->status = Package::STATUS_CANCELLED;
        if( $package->save() ){
            $package_status_update = new PackageStatusUpdate;
            $package_status_update->status = $package->status;
            $package_status_update->package_id = $package->id;
            $package_status_update->user_id = auth()->user()->id;
            $package_status_update->save();
        }
        return redirect()->to('/order/'.$package->order->id.'/details');
    }





    // =======================================================
    // For Stores
    // =======================================================

    public function orders(PackagesDataTable $dataTable)
    {
        return $dataTable->render('store.seller.orders');
    }

    public function show_for_store(Package $package)
    {
        $this->authorize('show_for_store', $package);
        return view('store.seller.order')->with([
            'order' => $package->order,
            'package' => $package,
        ]);
    }

    public function change_status(Request $request)
    {
        $package = Package::findOrFail( $request->package_id );
        $this->authorize('change_status', $package);

        if($package->is_pending()){
            if( $request->package_status == 'approved' ){
                $package->status = Package::STATUS_APPROVED;
            } else if( $request->package_status == 'rejected' ){
                if( $request->rejection_type == 2 ){
                    $package->status = Package::STATUS_SOFT_REJECTED;
                } else {
                    $package->status = Package::STATUS_HARD_REJECTED;
                }
            }
        } else if( $package->is_deliverable() ){
            if( $request->package_status == 'prepared' ){
                $package->status = Package::STATUS_PREPARED;
            } else if( $request->package_status == 'cancelled' ){
                $package->status = package::STATUS_CANCELLED;
            }

        } else {
            if( $request->package_status == 'backward' ){
                if( $package->is_approved() || $package->is_rejected() ){
                    $package->status = Package::STATUS_PENDING;
                } elseif( $package->is_prepared() ){
                    $package->status = Package::STATUS_DELIVERABLE;
                } elseif( $package->is_cancelled()){
                    $status_before_cancelling = $package->package_status_updates()->latest()->offset(1)->first();
                    if($package->is_cancelled_by_buyer() && auth()->user()->id == $package->user_id){
                        $package->status = $status_before_cancelling ? $status_before_cancelling->status : Package::STATUS_PENDING;
                    } elseif(!$package->is_cancelled_by_buyer() && auth()->user()->id == $package->store_id) {
                        $package->status = $status_before_cancelling ? $status_before_cancelling->status : Package::STATUS_PENDING;
                    }
                } elseif( $package->is_delivered() ){
                    $package->status = Package::STATUS_PREPARED;
                }
            } else if( $request->package_status == 'forward' ){
                if( $package->is_approved()){
                    $package->status = Package::STATUS_DELIVERABLE;
                } elseif( $package->is_rejected() ){
                    $package->status = Package::STATUS_DELIVERABLE;
                } elseif( $package->is_prepared() ){
                    $package->status = Package::STATUS_DELIVERED;
                } elseif( $package->is_cancelled()){
                    $status_before_cancelling = $package->package_status_updates()->latest()->offset(1)->first();
                    $package->status = $status_before_cancelling ? $status_before_cancelling->status : Package::STATUS_PENDING;
                    switch ($package->status) {
                        case Package::STATUS_PENDING: $package->status = Package::STATUS_APPROVED; break;
                        case Package::STATUS_APPROVED: $package->status = Package::STATUS_DELIVERABLE; break;
                        case Package::STATUS_DELIVERABLE: $package->status = Package::STATUS_PREPARED; break;
                        default: $package->status = Package::STATUS_APPROVED; break;
                    }
                }
            }
        }

        if( $package->save() ){
            $package_status_update = new PackageStatusUpdate;
            $package_status_update->status = $package->status;
            $package_status_update->package_id = $package->id;
            $package_status_update->user_id = auth()->user()->id;
            $package_status_update->note = $request->note ?? null;
            if($package_status_update->save()){
                if($request->ajax())
                    return response()->json( view('store.partials.change-status-options')->with('package', $package)->render() , 200);
                return redirect()->back();
            }
        }
        return response()->json('ليست لديك الصلاحيات لإجراء هذا التغيير', 403);
    }

    public function get_shipping(Request $request){
        $package = Package::findOrFail( $request->package_id );
        $this->authorize('show_for_store', $package);
        // return $package->shipping ?? '-';
        return '-';
    }

    public function get_status(Request $request){
        $package = Package::findOrFail( $request->package_id );
        $this->authorize('show_for_store', $package);
        return $package->status();
    }

    public function get_status_updates_log(Request $request){
        $package = Package::findOrFail( $request->package_id );
        $this->authorize('show_for_store', $package);
        return response()->json( view('store.partials.package-status-updates')->with('package', $package)->render() ,200);
    }
}
