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


            <img class="postThumbnail" src="{{$post->image->url()}}">

            <p>Currently read by {{$counter}} people</p>

            @include('comments.partials._form')

            <h4>Comments</h4>
            @forelse($post->comments as $comment)
                <p>{{$comment->content}}</p>
                @updated(['date'=>$comment->created_at->diffForHumans(), 'name'=>$comment->user->name])
                @endupdated
            @empty
                <p>No comments yet!</p>
            @endforelse
        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
