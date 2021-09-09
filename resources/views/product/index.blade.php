@extends('templates.template')
@section('title', "Products")
@section('content')
    <ttable class="w-100 mt-2" :header='["#", "Title", "Price", "Actions"]'>
        @foreach ($products as $product)
            <product-TR 
                id="{{$product['id']}}"
                title="{{$product['name']}}"
                price="{{$product['price']}}">
            </product-TR>
        @endforeach
    </ttable>
@endsection