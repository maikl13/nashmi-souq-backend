<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = new Cart;

        return view('store.cart')->with([
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $product = Product::findOrFail($product_id);

        $cart = new Cart;
        $cart->add($product, $quantity);
    }

    public function remove_from_cart($store, $product_id)
    {
        $cart = new Cart;
        $cart->remove($product_id);
    }

    public function update_cart_dropdown()
    {
        return response()->json(view('store.partials.cart-dropdown')->render(), 200);
    }

    public function update_product_quantity(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        $cart = new Cart;
        $cart->update_quantity($product->id, $quantity);
        $item = isset($cart->items()[$product->id]) ? $cart->items()[$product->id] : false;
        if ($item) {
            return response()->json(view('store.partials.cart-item')->with([
                'product_id' => $product->id,
                'product' => $item,
            ])->render(), 200);
        }

        return response()->json('', 200);
    }

    public function update_totals(Request $request)
    {
        $cart = new Cart;

        return response()->json(view('store.partials.totals')->with(['cart' => $cart])->render(), 200);
    }

    public function checkout()
    {
        $cart = new Cart;

        return view('store.checkout')->with([
            'cart' => $cart,
        ]);
    }
}
