<?php

namespace App\Http\Services\Cart;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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

    protected function isValidOrder($request){
        if ($request->input('name') == null || $request->input('phone')== null || $request->input('address')== null ){
            Session::flash('error','Please enter your name, phone and address !');
            return false;
        }

        return true;
    }

    public function checkout($request){
        $isValidInfo = $this->isValidOrder($request);
        if ($isValidInfo == false)   return false;

        try {
            DB::beginTransaction();
            $carts = Session::get('carts');

            if (is_null($carts)) return false;

            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content'),
            ]);

            $this->productCartInfo($carts, $customer->id);

            DB::commit();

            Session::flash('success','The order has been placed !');

            Session::forget('carts');
        } catch (\Throwable $th) {
            DB::rollBack();

            Session::flash('error','An error occurred while placing the order, please try again later !');

            return false;
        }

        return true;
    }

    protected function productCartInfo($carts , $customer_id){
        $productId = array_keys($carts);
        $products =  Product::select('id','name','price','price_sale','thumb')
        ->where('active',1)
        -> whereIn('id', $productId)
        -> get();

        $data = [];
        foreach ($products as  $product ){
            $data []= [
                'customer_id' => $customer_id,
                'product_id' => $product -> id ,
                'quantity' => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
            ];
        }

        return Cart::insert($data);;
    }

    public function getCustomer() {
        return Customer::orderByDesc('id')->paginate(8);
    }

    public function getProductCart($customer) {
        return $customer->carts()->with(['product'=> function ($query){
            $query->select('id','name' ,'thumb');
        }])->get();
    }
}
