@extends('admin.main')

@section('content')
<div class="customer mt-4" >
    <ul>
        <li>
            Name: <strong>{{ $customer->name }}</strong>
        </li>
        <li>
            Phone: <strong>{{ $customer->phone }}</strong>
        </li>
        <li>
            Address: <strong>{{ $customer->address }}</strong>
        </li>
        <li>
            Email: <strong>{{ $customer->email }}</strong>
        </li>
        <li>
            Note: <strong>{{ $customer->content }}</strong>
        </li>
    </li>
    </ul>
</div>

<div class="cart">
    <div class="wrap-table-shopping-cart">
        @php
            $total = 0;
        @endphp

        <table class="table">
            <tr class="table_head">
                <th class="column-1">Product</th>
                <th class="column-2">Name</th>
                <th class="column-3">Price</th>
                <th class="column-4">Quantity</th>
                <th class="column-5">Total</th>

            </tr>

            @foreach($carts as $cart)
            @php
                $price = $cart->quantity * $cart->price;
                $total +=$price;
            @endphp
            <tr class="table_row">
                <td class="column-1">
                    <div class="how-itemcart1">
                        <img src="{{ $cart->product->thumb }}" alt="{{ $cart->product->name  }}" width="60px" height="60px">
                    </div>
                </td>
                <td class="column-2">{{ $cart->product->name }}</td>
                <td class="column-3">{{number_format($cart->price, 0, ',','.') . ' VND' }}</td>
                <td class="column-4">{{ $cart->quantity }}</td>
                <td class="column-5">{{number_format($price, 0, ',','.') . ' VND'  }}</td>

            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right">
                    Total:
                </td>
                <td>{{number_format($total, 0, ',','.') . ' VND'  }}</td>
            </tr>
        </table>

    </div>
</div>

@endsection


