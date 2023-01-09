@extends('layouts.app')

@section('title',$post['title'])

@section('content')
    @if($post['is_new'])
        <div>A new blog post!</div>
    @else
        <div>An old blog post!</div>
    @endif

    @unless($post['is_new'])
        <div>An old blog post using unless!</div>
    @endunless
    <h1>{{$post['title']}}</h1>
    <p>{{$post['content']}}</p>

    @isset($post['has_comments'])
        <div>The post has comments</div>
    @endisset

    @disk('local')
    Local
    @enddisk

    @admin
    It is admin
    @endadmin


@endsection
