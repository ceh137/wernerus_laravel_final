@extends('index.layouts.main')
@section('content')
    <calculator :order="{{$data}}" :to_order="false" :repeat='false' :from_index="true"></calculator>
@endsection
