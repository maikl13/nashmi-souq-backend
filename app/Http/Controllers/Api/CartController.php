<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Auth;
use DB;
class CartController extends Controller
{
   
      public function index($store)
    {          
    $user=Auth::user();
       
    $cart = Cart::join('products','products.id','carts.product_id')
        ->where('store_id',$store->id)->where('carts.user_id',$user->id)
        ->with('currency:id,name,code')
        ->select(['carts.*','products.title','products.images','products.price'])->paginate(3);
        return new JsonResponse([
            'cart' => $cart,
        ]);
        
    }

    public function store($store,Request $request,$code)
    {   $user=Auth::user();
        $country = Country::where('code', $code)->first();

        $product_id = $request->product_id;
        $quantity =(int)$request->quantity;
        $product = Product::findOrFail( $product_id );
         $cartsearch = Cart::where('product_id',$product_id )->where('store_id',$store->id)->where('user_id',$user->id)->first();
         if($cartsearch){
          
            $cartsearch->quantity=$quantity;
           $cartsearch->save();
               return new JsonResponse([
            'status' => 'update cart successfully.'
        ]);
         }else{
              $cart= new Cart;
           $cart->product_id=$product->id;
            $cart->user_id=Auth::user()->id;
            $cart->store_id=$store->id;
            $cart->quantity=$request->quantity;
            $cart->state_id=$request->state_id;
            $cart->currency_id=$country->currency->id;
           
           $cart->save();
             return new JsonResponse([
            'status' => 'add cart successfully.'
        ]);
         }
      
    }


    public function remove_from_cart($store, $product_id)
    {    $user=Auth::user();
         $cart = Cart::where('product_id',$product_id )->where('store_id',$store->id)->where('user_id',$user->id)->first();
          if($cart){
        $cart->delete();
         return new JsonResponse([
            'status' => 'remove item successfully.'
        ]);
          }else{
               return new JsonResponse([
            'status' => 'this item not found.'
        ]);
          }

       
    }

    public function update_cart_dropdown(){
        $cart = new Cart;
        return new JsonResponse([
            'cart_dropdown' => view('store.partials.cart-dropdown')->with(['cart' => $cart])->render()
        ]);
    }

    public function update_product_quantity($store,Request $request){
        $user=Auth::user();
        $cart = Cart::where('product_id',$request->product_id )->where('store_id',$store->id)->where('user_id',$user->id)->first();
        $product = Product::findOrFail($request->product_id );
        $quantity = (int)$request->quantity;
          if($cart){
         $cart->quantity=$quantity;
           $cart->save();
               return new JsonResponse([
            'status' => 'update cart successfully.',
            'product'=>$cart
        ]);
          }else{
                      return new JsonResponse([
            'status' => 'No item in a Cart.'
        ]);
          }
      

          
    }

    public function update_totals($store,Request $request){
     $user=Auth::user();
    //  $cart = Cart::join('products','products.id','carts.product_id')
    //      ->where('carts.store_id',$store->id)
    //      ->where('carts.user_id',$user->id)
    //      ->select(['products.price * carts.quantity as total_price','carts.*'])->get();
        $cart =  DB::table('carts')
        ->where('carts.store_id',$store->id)
        ->where('carts.user_id',$user->id)
        ->join('products','products.id','=','carts.product_id')
        ->select(['products.title','products.price','carts.quantity','products.images',DB::raw('(carts.quantity * products.price) as total_price')])
        ->get();
        $sum_total =  DB::table('carts')
        ->where('carts.store_id',$store->id)
        ->where('carts.user_id',$user->id)
        ->join('products','products.id','=','carts.product_id')
        ->select(DB::raw('SUM(carts.quantity * products.price) as sum_total'))
        ->get();  
        return new JsonResponse([
            'cart' => $cart,
            'sum_total'=>$sum_total
        
        ]);
    }

    public function checkout(){
        $cart = new Cart;
        return new JsonResponse([
            'cart' => $cart,
            'request'=>request()->all()
            ]);
    }

}
