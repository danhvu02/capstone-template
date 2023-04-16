@extends('common') 

@section('pagetitle')
Shopping Cart
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Your Cart</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems->groupBy('item_id') as $itemGroup)
                            @php
                                $item = $itemGroup->first();
                                $quantity = $itemGroup->sum('quantity');
                            @endphp
                            <tr>
                                <td>{{ $item->item->title }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control" value="{{ $quantity }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>${{ $item->item->price }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>Subtotal:</strong></td>
                            <td>${{ $cartItems->sum(function($item) { return $item->item->price * $item->quantity; }) }}</td>
                        </tr>
                    </tbody>
                </table>

                <h2>Customer Information</h2>
                {!! Form::open(['route' => 'check_order', 'id' => 'order-form']) !!}
                {{ csrf_field() }}
                <div class="form-group">
                    {!! Form::label('first_name', 'First Name') !!}
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'Enter first name', 'required' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('last_name', 'Last Name') !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => 'Enter last name', 'required' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone', 'Phone') !!}
                    {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Enter phone', 'required' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email', 'required' => true]) !!}
                </div>
                {{ Form::hidden('session_id', session()->getId()) }}
                {{ Form::hidden('ip', session()->get('ip')) }}
                <!-- display cart items here -->
                {!! Form::submit('Submit Order', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
                @yield('scripts')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection