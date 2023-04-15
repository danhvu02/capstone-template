@extends('common') 

@section('pagetitle')
Product Detail
@endsection

@section('pagename')
Laravel Project
@endsection

@section('scripts')
{!! Html::script('/bower_components/parsleyjs/dist/parsley.min.js') !!}
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if (Storage::disk('public')->exists('images/items/' . $item->picture))
               <img  src="{{ asset('storage/images/items/' . $item->picture) }}" alt="{{ $item->title }} " width="100%" />
            @else
                No image available
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $item->title }}</h2>
            <p>Product ID: {{ $item->id }}</p>
            <p>Description (below): {!! $item->description !!}</p>
            <p>Price: ${{ $item->price }}</p>
            <p>Quantity: {{ $item->quantity }}</p>
            <p>SKU: {{ $item->sku }}</p>
            <a href="#" class="btn btn-primary">Buy Now</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>

        </div>
    </div>
</div>
@endsection