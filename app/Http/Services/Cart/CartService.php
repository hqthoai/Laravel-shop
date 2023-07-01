<?php

namespace App\Http\Services\Cart;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartService
{

    public function create($request){
        $quantity = (int)$request->input('num-product');
        $product_id = (int) $request -> input('product-id');

        if($quantity <= 0 || $product_id <= 0){
            Session::flash('error','Please choose the number of product!');
            return false;
        }
        $carts = Session::get('carts');
        if (is_null($carts)){
            $carts[$product_id] = $quantity;
            Session::put('carts', $carts);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);
        if ($exists){
            $carts[$product_id] =  $carts [$product_id] + $quantity;
            Session::put('carts', $carts);
            return true;
        }
        else {
            $carts[$product_id] = $quantity;
            Session::put('carts', $carts);
        }

        return true;
    }

    public function getProduct(){
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $productId = array_keys($carts);
        return Product::select('id','name','price','price_sale','thumb')
        ->where('active',1) -> whereIn('id', $productId) -> get();
    }

    public function update($request){
        $quantities = $request->input('num-product');
        $carts = Session::get('carts');
        foreach ($quantities as $key => $quantity) {
            if ($quantity == 0) {
                unset($carts[$key]);
            } else {
                $carts[$key] = $quantity;
            }
        }
        Session::put('carts', $carts);

        return true;
    }

    public function remove($id){
        $carts = Session::get('carts');
        unset($carts[$id]);
        Session::put('carts', $carts);
        return true;
    }
}
