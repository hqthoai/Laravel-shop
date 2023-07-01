<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class ProductAdminService
{

    public function getMenu()
    {
        return Menu::where('active',1)->get();
    }

    public function get()
    {
        return Product::with('category')
        ->orderBy('id','asc')->paginate(8);
    }

    protected function isValidPrice($request){

        if ($request->input('price') != 0 && $request->input('price_sale') != 0
        && $request->input('price_sale') >=  $request->input('price') ){
            Session::flash('error', 'Reduced Price sale must be less than original price!');
            return false;
        }

        if ( (int)$request->input('price')==0 && $request->input('price_sale')!=0) {
            Session::flash('error', 'Please enter the original price!');
            return false;
        }

        return true;
    }

    public function create($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false){
            return false;
        }
        try {
            $request->except('_token');
            Product::create($request->all());

            Session::flash('success', 'Add new product successfully !');
        } catch (\Exception $err) {
            Session::flash('error', 'Add new product failed !');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $id =  $request->input('id');
        $product = Product::where('id', $id)->first();
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false){
            return false;
        }

        try {
            $product->fill($request->input());
            $product->save();

            Session::flash('success','Update product successfully');
        } catch (\Exception $err) {
            Session::flash('error','Update product failed');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }
}
