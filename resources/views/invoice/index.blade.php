@extends('templates.template')
@section('title', "Products")
@section('content')
    {{$data}}
    {{-- @foreach ($invoices as $invoice)
        @foreach ($invoice->products as $product)
            {{$product->product}}
        @endforeach
    @endforeach --}}
@endsection