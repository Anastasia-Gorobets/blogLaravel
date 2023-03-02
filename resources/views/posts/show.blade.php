@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/posts.css') }}" rel="stylesheet">
@endsection

@section('title',$post['title'])

@section('content')

    <div class="row">
        <div class="col-8">
            <h1>{{$post->title}}</h1>
            <p>{{$post->content}}</p>

            @updated(['date'=>$post->created_at->diffForHumans(), 'name'=>$post->user->name])
            @endupdated

            @tags(['tags'=>$post->tags])
            @endtags


            <img class="postThumbnail" src="{{$post->image ? $post->image->url() : ''}}">

            <p>Currently read by {{$counter}} people</p>

            @commentForm(['route'=>route('posts.comments.store', ['post'=>$post->id])]) @endcommentForm

            @commentsList(['comments'=>$post->comments]) @endcommentsList

        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
