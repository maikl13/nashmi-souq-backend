<?php

namespace App\Models;

use Cookie;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $cart = [];

	public function __construct(){
		$this->cart = Self::get_current_cart();
	}

    public function add(Product $product, $quantity){
        $cart = $this->cart;
        $cart['items'][$product->id] = isset( $cart['items'][$product->id] ) ? (int)$cart['items'][$product->id]+$quantity : (int)$quantity;
        Cookie::queue('cart', json_encode($cart), 3*24*60, null, request()->gethost());
        // return response()->json( print_r(json_encode($cart)) , 200);
        $this->cart = $cart;
    }

    public function remove($product_id){
        $cart = $this->cart;
        if( isset($cart['items'][$product_id]) ) unset($cart['items'][$product_id]);
        Cookie::queue('cart', json_encode($cart), 3*24*60, null, request()->gethost());
        $this->cart = $cart;
    }

    public function clear(){
        $cart = $this->cart;
        $cart = [];
        Cookie::queue('cart', json_encode($cart), 3*24*60, null, request()->gethost());
        $this->cart = $cart;
    }

    public function update_quantity($product_id, $quantity){
        $cart = $this->cart;
        if( isset($cart['items'][$product_id]) ) $cart['items'][$product_id] = $quantity;
        Cookie::queue('cart', json_encode($cart), 3*24*60, null, request()->gethost());
        if( $cart['items'][$product_id] == 0 ){
            Self::remove($product_id);
        } else{
            $this->cart = $cart;
        }
    }

    public function get_current_cart(){
    	$cart = request()->cookie('cart');
    	$cart = json_decode($cart, true);
    	return is_array($cart) ? $cart : [];
    }






    // Helpers To get Data
    public function items(){
        $cart = $this->cart;
        $items = [];
        if(is_array($cart) && isset($cart['items']) && is_array($cart['items'])){
            foreach($cart['items'] as $product_id => $quantity){
                $product = Product::find( $product_id );
                if($product && $product->is_available() && $product->is_eligible_for_cart()) {
                    $items[$product_id]['title'] = $product->title;
                    $items[$product_id]['image'] = $product->product_images()[0];
                    $items[$product_id]['url'] = $product->url();
                    $items[$product_id]['price'] = $product->local_price();
                    $items[$product_id]['currency'] = country()->currency_symbol;
                    $items[$product_id]['quantity'] = $quantity;
                } else {
                    unset($cart['items'][$product_id]);
                    $this->remove($product_id);
                }
            }
            // Cookie::queue('cart', json_encode($cart), 3*24*60, null, request()->gethost());
        }
        return $items;
    }

    public function total_price(){
        $price = 0;
        foreach( Self::items() as $item) {
            $price += $item['price'] * $item['quantity'];
        }
        return $price;
    }

    public function fees(){
        return 0;
        $price = 0;
        foreach( Self::items() as $item) {
            $price += $item['price'] * $item['quantity'];
        }
        return ceil($price * 0.01);
    }

    public function taxes(){
        return 0;
        $price = 0;
        foreach( Self::items() as $item) {
            $price += $item['price'] * $item['quantity'];
        }
        return ceil($price * 0.14);
    }

    public function shipping(){
        return 0;
    }

    public function discount(){
        return 0;
    }

    public function total_quantity(){
    	$cart = $this->cart;
    	$quantity = 0;
    	if( isset($cart['items']) && is_array($cart['items']) ){
	    	foreach ($cart['items'] as $product_id => $qty) {
	    		$quantity += is_numeric($qty) ? (int)$qty : 0;
	    	}
	    }
    	return $quantity;
    }

    public function items_quantity(){
    	$cart = $this->cart;
    	return isset($cart['items']) && is_array($cart['items']) ? sizeof($cart['items']) : 0;
    }
}
