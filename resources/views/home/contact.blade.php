@extends('layouts.app')
@section('title','Contact page')
@section('content')
    <h1>Contact</h1>

    @can('home.secret')
        <p>Special link!</p>
        <a href="{{route('home.secret')}}">Secret ...</a>
    @endcan
@endsection
