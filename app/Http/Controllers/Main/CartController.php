<?php

namespace App\Http\Controllers\Main;

use App\Models\Listing;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $cart = new Cart;
        return view('store.buyer.cart')->with([
            'cart' => $cart
        ]);
    }

    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $product = Listing::findOrFail( $product_id );

        $cart = new Cart;
        $cart->add($product, $quantity);
    }


    public function remove_from_cart($product_id)
    {
        $cart = new Cart;
        $cart->remove($product_id);
    }

    public function update_cart_dropdown(){
        return response()->json( view('store.partials.cart-dropdown')->render(), 200);
    }

    public function update_product_quantity(Request $request){
        $product = Listing::findOrFail( $request->product_id );
        $quantity = (int)$request->quantity;

        $cart = new Cart;
        $cart->update_quantity($product->id, $quantity);
        $item = isset($cart->items()[$product->id]) ? $cart->items()[$product->id] : false;
        if( $item ){
            return response()->json( view('store.partials.cart-item')->with([
                'product_id' => $product->id,
                'product' => $item
            ])->render() , 200);
        }
            return response()->json('' , 200);
    }

    public function update_totals(Request $request){
        $cart = new Cart;
        return response()->json( view('store.partials.totals')->with(['cart' => $cart])->render() , 200);
    }

    public function checkout(){
        $cart = new Cart;
        return view('store.buyer.checkout')->with([
            'cart' => $cart
        ]);
    }
}
