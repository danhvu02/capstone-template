@extends('layouts.app')

@section('content')
    <h1>Order Receipt</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Order Details</h5>
            <p class="card-text"><strong>Order ID:</strong> {{ $order->id }}</p>
            <p class="card-text"><strong>Customer Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ $order->phone }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $order->email }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Order Items</h5>
            <table class="table">
                <thead>
                    <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    </tr>
                </thead>
            <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right">Total:</td>
                <td>{{ $order->total }}</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            
@endsection