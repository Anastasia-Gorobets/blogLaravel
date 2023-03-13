@extends('layouts.app')
@section('title','Posts')
@section('content')

<div class="row">
    <div class="col-8">
        @forelse($posts as $key=>$post)
            @if($post->trashed())
                <del>
            @endif
            @updated(['date'=>$post->created_at->diffForHumans(), 'name'=>$post->user->name, 'userId'=>$post->user->id])
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
        @include('posts._activity')
    </div>
</div>
@endsection
