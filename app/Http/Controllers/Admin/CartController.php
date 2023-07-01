<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Cart\CartService;
use App\Models\Customer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index() {
        return view ('admin.cart.customer',[
            'title' => 'Order List',
            'customers' => $this->cartService->getCustomer()
        ]);
    }

    public function show(Customer $customer) {
        $carts =$this->cartService->getProductCart($customer);

        return view ('admin.cart.detail',[
            'title' => 'Detailed Order: '. $customer->name,
            'customer' => $customer,
            'carts' => $carts
        ]);
    }
}
