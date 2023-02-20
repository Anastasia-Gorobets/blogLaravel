@extends('layouts.app')
@section('title','Posts')
@section('content')
<div class="row">
    <div class="col-8">
        @forelse($posts as $key=>$post)
            @if($post->trashed())
                <del>
            @endif
            @updated(['date'=>$post->created_at->diffForHumans(), 'name'=>$post->user->name])
            @endupdated
            @include('posts.partials.post')
             @if($post->trashed())
                 </del>
             @endif

            @tags(['tags'=>$post->tags])
            @endtags


        @empty
            <p>No posts</p>
        @endforelse
    </div>
    <div class="col-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    @card(['title'=>'Most commented posts'])
                    @slot('items')
                        @foreach($mostCommentedPosts as $key=>$post)
                            <li><a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a></li>
                        @endforeach
                    @endslot
                    @endcard
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @card(['title'=>'Most active users'])
                    @slot('items', collect($mostActive)->pluck('name'))
                    @endcard
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @card(['title'=>'Most active users last month'])
                    @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                    @endcard
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
