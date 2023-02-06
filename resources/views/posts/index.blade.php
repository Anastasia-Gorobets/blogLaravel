@extends('layouts.app')

@section('title','Posts')

@section('content')

@forelse($posts as $key=>$post)
    <p class="text-muted">Added  {{$post->created_at->diffForHumans()}} by {{$post->user->name}}</p>
    @include('posts.partials.post')
@empty
<p>No posts</p>
@endforelse

@php $test = 'Some text' @endphp

<p>{{$test}}</p>

@endsection
