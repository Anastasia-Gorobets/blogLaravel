@extends('layouts.app')

@section('title',$post['title'])

@section('content')
    <h1>{{$post->title}}</h1>
    <p>{{$post->content}}</p>
    <p>Added {{$post->created_at->diffForHumans()}}</p>

    <h4>Comments</h4>
    @forelse($post->comments as $comment)
        <p>{{$comment->content}}, added {{$comment->created_at->diffForHumans()}}</p>
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
