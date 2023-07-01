<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class ProductService
{

    const LIMIT = 12;

    public function get( $page = null)
    {
        return Product::select('id','name','price','price_sale','thumb')
        ->orderByDesc('id')
        ->when($page !== null , function ($query) use ($page){
            $query ->offset( $page * self::LIMIT );
        })
        ->limit(self::LIMIT)->get();
    }

    public function show ($id){
        return Product::where('id', $id)->where('active',1)->with('category')->firstOrFail();
    }

    public function more($id, $categoryId){
        return Product::select('id','name','price','price_sale','thumb')
        -> where('active', 1)
        -> where('id','!=',$id)
        -> where ('category_id',$categoryId)
        -> orderByDesc('id')
        -> limit (8)
        -> get();
    }
}
