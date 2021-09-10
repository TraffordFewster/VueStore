@extends('templates.template')
@section('title', "Invoices")
@section('content')
    <invoice-index :invoices='{!! $data !!}'></invoice-index>
@endsection