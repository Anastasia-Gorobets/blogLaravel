@extends('layouts.app')

@section('title',$post['title'])

@section('content')
    <h1>{{$post->title}}</h1>
    <p>{{$post->content}}</p>

    @updated(['date'=>$post->created_at->diffForHumans()])
    @endupdated

    <h4>Comments</h4>
    @forelse($post->comments as $comment)
        <p>{{$comment->content}}</p>
        @updated(['date'=>$comment->created_at->diffForHumans()])
        @endupdated
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
