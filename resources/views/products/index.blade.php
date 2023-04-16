@extends('common') 

@section('pagetitle')
Product List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>Categories</h2>
            <ul>
                @foreach($categories as $category)
                <li><a href="{{ route('chosenCategory', $category->id) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9">
            <h2>Products</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                @if (Storage::disk('public')->exists('images/items/' . $item->picture))
                                <a href="{{ route('products.show', $item->id) }}"><img  src="{{ asset('storage/images/items/tn_' . $item->picture) }}" alt="{{ $item->title }} "/></a>              
                                @else
                                    No image available
                                @endif
                            </td>
                            <td><a href="{{ route('products.show', $item->id) }}">{{ $item->title }}</a></td>
                            <td>${{ $item->price }}</td>
                            <td><a href="{{ route('products.addToCart', $item->id) }}" class="btn btn-primary">Add to cart</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection