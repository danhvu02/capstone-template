@extends('layouts.app')

@section('content')
    <h1>Completed Orders</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->email }}</td>
                    <td>${{ $order->total_amount }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="btn btn-primary">View Receipt</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
