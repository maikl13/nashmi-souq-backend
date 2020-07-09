<?php

namespace App\Http\Controllers\Main;

use App\Models\Order;
use App\Models\OrderStatusUpdate;
use App\Models\Cart;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('main.store.buyer.my-orders')->with('orders', auth()->user()->orders()->latest()->paginate(12));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('main.store.buyer.order')->with('order', $order);
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

        foreach($items as $id => $item){
            $listing = Listing::findOrFail($id);
            $order = new Order;
            $order->store_id = $listing->user->id;

            // order info
            $order->uid = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
            $order->shipping_method = Order::NO_SHIPPING;
            $order->shipping = $request->shipping_method == Order::NO_SHIPPING ? 0 : null;
            $order->payment_method = $request->payment_method;
            $order->status = Order::STATUS_PENDING;

            // product info
            $order->listing_id = $listing->id;
            $order->title = $item['title'];
            $order->quantity = $item['quantity'];
            $order->price = $item['price'];

            // buyer info
            $order->user_id = auth()->user()->id;
            $order->buyer_name = $request->name;
            $order->state_id = $request->state;
            $order->phone = $request->phone;
            $order->address = $request->address;

            $order->save();
        }

        $cart->clear();
        $user = auth()->user();
        $user->shipping_address = $order->address;
        $user->state_id = $request->state;
        $user->save();
        return redirect()->route('order-saved');
    }

    public function order_saved()
    {
        return view('main.store.buyer.order-saved');
    }

    public function cancel_order(Order $order)
    {
        $this->authorize('cancel', $order);
        $order->status = Order::STATUS_CANCELLED;
        if( $order->save() ){
            $order_status_update = new OrderStatusUpdate;
            $order_status_update->status = $order->status;
            $order_status_update->order_id = $order->id;
            $order_status_update->user_id = auth()->user()->id;
            $order_status_update->save();
        }
        return redirect()->to('/order/'.$order->id.'/details');
    }

    public function confirm_order(Order $order)
    {
        $this->authorize('confirm', $order);
        $order->status = Order::STATUS_DELIVERABLE;
        $order->payment_method = Order::ON_DELIVERY_PAYMENT;
        if( $order->save() ){
            $order_status_update = new OrderStatusUpdate;
            $order_status_update->status = $order->status;
            $order_status_update->order_id = $order->id;
            $order_status_update->user_id = auth()->user()->id;
            $order_status_update->save();
        }
        return redirect()->to('/order/'.$order->id.'/details');
    }





    // =======================================================
    // For buyers
    // =======================================================


    public function orders(OrdersDataTable $dataTable)
    {
        return $dataTable->render('main.store.seller.orders');
    }


    public function show_for_buyer(Order $order)
    {
        $this->authorize('show_for_buyer', $order);
        return view('main.store.seller.order')->with([
            'order' => $order
        ]);
    }


    public function change_status(Request $request)
    {
        $order = Order::findOrFail( $request->order_id );
        $this->authorize('change_status', $order);

        if($order->is_pending()){
            if( $request->order_status == 'approved' ){
                $order->shipping = (int)$request->shipping;
                $order->status = Order::STATUS_APPROVED;
            } else if( $request->order_status == 'rejected' ){
                if( $request->rejection_type == 2 ){
                    $order->status = Order::STATUS_SOFT_REJECTED;
                } else {
                    $order->status = Order::STATUS_HARD_REJECTED;
                }
            }
        } else if( $order->is_deliverable() ){
            if( $request->order_status == 'prepared' ){
                $order->status = Order::STATUS_PREPARED;
            } else if( $request->order_status == 'cancelled' ){
                $order->status = Order::STATUS_CANCELLED;
            }

        } else {
            if( $request->order_status == 'backward' ){
                if( $order->is_approved() || $order->is_rejected() ){
                    $order->shipping = null;
                    $order->status = Order::STATUS_PENDING;
                } elseif( $order->is_prepared() ){
                    $order->status = Order::STATUS_DELIVERABLE;
                } elseif( $order->is_cancelled()){
                    $status_before_cancelling = $order->order_status_updates()->latest()->offset(1)->first();
                    if($order->is_cancelled_by_buyer() && auth()->user()->id == $order->user_id){
                        $order->status = $status_before_cancelling ? $status_before_cancelling->status : Order::STATUS_PENDING;
                    } elseif(!$order->is_cancelled_by_buyer() && auth()->user()->id == $order->store_id) {
                        $order->status = $status_before_cancelling ? $status_before_cancelling->status : Order::STATUS_PENDING;
                    }
                } elseif( $order->is_delivered() ){
                    $order->status = Order::STATUS_PREPARED;
                }
            } else if( $request->order_status == 'forward' ){
                if( $order->is_approved()){
                    $order->status = Order::STATUS_DELIVERABLE;
                } elseif( $order->is_rejected() ){
                    if($order->is_rejected())
                        $order->shipping = (int)$request->shipping;
                    $order->status = $order->shipping > 0 ? Order::STATUS_APPROVED :  Order::STATUS_DELIVERABLE;
                } elseif( $order->is_prepared() ){
                    $order->status = Order::STATUS_DELIVERED;
                } elseif( $order->is_cancelled()){
                    $status_before_cancelling = $order->order_status_updates()->latest()->offset(1)->first();
                    $order->status = $status_before_cancelling ? $status_before_cancelling->status : Order::STATUS_PENDING;
                    switch ($order->status) {
                        case Order::STATUS_PENDING: $order->status = Order::STATUS_APPROVED; break;
                        case Order::STATUS_APPROVED: $order->status = Order::STATUS_DELIVERABLE; break;
                        case Order::STATUS_DELIVERABLE: $order->status = Order::STATUS_PREPARED; break;
                        default: $order->status = Order::STATUS_APPROVED; break;
                    }
                }
            }
        }

        if( $order->save() ){
            $order_status_update = new OrderStatusUpdate;
            $order_status_update->status = $order->status;
            $order_status_update->order_id = $order->id;
            $order_status_update->user_id = auth()->user()->id;
            $order_status_update->note = $request->note ?? null;
            if($order_status_update->save()){
                if($request->ajax())
                    return response()->json( view('main.store.partials.change-status-options')->with('order', $order)->render() , 200);
                return redirect()->back();
            }
        }
        return response()->json('ليست لديك الصلاحيات لإجراء هذا التغيير', 403);
    }

    public function get_shipping(Request $request){
        $order = Order::findOrFail( $request->order_id );
        $this->authorize('show_for_buyer', $order);
        return $order->shipping ?? '-';
    }

    public function get_status(Request $request){
        $order = Order::findOrFail( $request->order_id );
        $this->authorize('show_for_buyer', $order);
        return $order->status();
    }

    public function get_status_updates_log(Request $request){
        $order = Order::findOrFail( $request->order_id );
        $this->authorize('show_for_buyer', $order);
        return response()->json( view('main.store.partials.order-status-updates')->with('order', $order)->render() ,200);
    }
}
