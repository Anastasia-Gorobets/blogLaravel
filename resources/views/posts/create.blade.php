@extends('layouts.app')

@section('title','Create the post')

@section('content')
    <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
        @csrf
        @include('posts.partials.form')
         <div>
            <input  class="btn btn-primary btn-block" type="submit" value="Create">
        </div>
    </form>
@endsection
