<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search() {
        $result ='';
        if (request('query')){
            $data = request('query');
            $result = Product::where('name','like','%'.$data.'%')
                            ->orderBy('name')
                            ->get();

            return view('search', [
                'products'=> $result])->render();
        }
        return $result;
    }

    public function find() {
        if (request('query'))
        {
            $data = request('query');

            $result = Product::where('name','like','%'.$data.'%')
                            -> orderBy('name')
                            -> paginate(12)
                            -> withQueryString();

            return view('product.search', [
                'title' => 'Result for '.$data,
                'products'=> $result])->render();
        }
        else return redirect() ->back();
    }

}
