@extends('admin.layout.index')
@section('content')
    <calculator :order="{{$data}}" :to_order="true" :repeat='true'></calculator>
@endsection
