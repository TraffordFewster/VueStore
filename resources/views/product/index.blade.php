@extends('templates.template')
@section('title', "Products")
@section('content')
    <product-index :products='{!! $products !!}'></product-index>
@endsection