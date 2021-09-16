@extends('templates.template')
@section('title', "Invoices")
@section('content')
    <invoice-index :invoices='{!! $data !!}' :allproducts='{!! $products !!}'></invoice-index>
@endsection