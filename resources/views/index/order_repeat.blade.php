@extends('index.layouts.main')
@section('content')
    <calculator :order="{{$data}}" :to_order="false" :repeat='true'></calculator>
@endsection
