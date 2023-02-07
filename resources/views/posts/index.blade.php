@extends('layouts.app')

@section('title','Posts')

@section('content')
<div class="row">
    <div class="col-8">
        @forelse($posts as $key=>$post)
            <p class="text-muted">Added  {{$post->created_at->diffForHumans()}} by {{$post->user->name}}</p>
            @include('posts.partials.post')
        @empty
            <p>No posts</p>
        @endforelse
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Most commented posts</h5>

                @foreach($mostCommentedPosts as $key=>$post)
                    @include('posts.partials.post')
                @endforeach
            </div>
        </div>
    </div>



</div>


@endsection
