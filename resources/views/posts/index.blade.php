@extends('layouts.app')

@section('title','Posts')

@section('content')

@forelse($posts as $key=>$post)
    @include('posts.partials.post')
@empty
<p>No posts</p>
@endforelse

@php $test = 'Some text' @endphp

<p>{{$test}}</p>

@endsection
