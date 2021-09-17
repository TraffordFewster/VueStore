@extends('templates.template')
@section('title', "Summaries")
@section('content')
    <summary-index :d='{!! $data !!}'></summary-index>
@endsection