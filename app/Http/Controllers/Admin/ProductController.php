<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductAdminService $productService)
    {
        $this ->productService = $productService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.list', [
            'title' => 'List of product',
            'products' => $this->productService->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.add',[
            'title' => 'Add new product',
            'menus' => $this -> productService->getMenu(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this ->productService->create($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view ('admin.product.edit',[
            'title' => 'Edit product: '.$product->name,
            'product' => $product,
            'menus' => $this -> productService->getMenu(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $result = $this->productService->update($request, $product);

        if ($result){
            return redirect('/admin/products/list');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = $this->productService->destroy($request);
        if ($result){
            return response () ->json([
                'error' => false,
                'message' => 'Delete product successfully !'
            ]);
        }
        return response () ->json([
            'error' => true
        ]);
    }
}
