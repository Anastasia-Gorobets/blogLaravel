@extends('layouts.app')

@section('title','Update the post')

@section('content')
    <form method="POST" action="{{route('posts.update', ['post'=>$post->id])}}">
        @method('PUT')
        @csrf
        @include('posts.partials.form')
        <div>
            <input type="submit" value="Update">
        </div>
    </form>
@endsection
