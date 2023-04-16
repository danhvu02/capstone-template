@extends('common')

@section('pagetitle')
Thank You
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')

    <div class="container mt-5">

        <h1 class="mb-4">Thank You for Your Order!</h1>

        <div class="card mb-5">
            <div class="card-header">
                <h2>Order Details</h2>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> {{ $orderId }}</p>
                <p><strong>First Name:</strong> {{ $firstName }}</p>
                <p><strong>Last Name:</strong> {{ $lastName }}</p>
                <p><strong>Phone:</strong> {{ $phone }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <tbody>
                    @foreach ($itemsSold as $item)
                        @php
                        $itemDetails = App\Models\Item::find($item->item_id);
                        $subtotal = $item->quantity * $itemDetails->price;
                        $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{$item->item_id}} - {{$itemDetails->name}}</td>
                            <td>
                                {{$item->quantity}}
                            </td>
                            <td>
                                ${{$itemDetails->price}}
                            </td>
                            <td>
                                ${{$subtotal}}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" style="text-align:right">Total:</td>
                        <td>${{$total}}</td>
                    </tr>
                </tbody>
            </table>
            
            </div>
        </div>

    </div>

@endsection