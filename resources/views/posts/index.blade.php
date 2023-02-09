@extends('layouts.app')

@section('title','Posts')

@section('content')
<div class="row">
    <div class="col-8">
        @forelse($posts as $key=>$post)
            @if($post->trashed())
                <del>
            @endif
            <p class="text-muted">Added  {{$post->created_at->diffForHumans()}} by {{$post->user->name}}</p>
            @include('posts.partials.post')
             @if($post->trashed())
                 </del>
             @endif
        @empty
            <p>No posts</p>
        @endforelse
    </div>

    <div class="col-4">
        <div class="container">
            <div class="row">
                <div class="col">
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

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Most active users</h5>
                            <ul>
                                @foreach($mostActive as $key=>$user)
                                    <li>{{$user->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Most active users last month</h5>
                            <ul>
                                @foreach($mostActiveLastMonth as $key=>$user)
                                    <li>{{$user->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



</div>


@endsection
