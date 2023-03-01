@extends('layouts.app')

@section('content')
        <div class="row">

            <div class="col-4">
                <img src="{{$user->image->url() ?  : ''}}" class="img-thumbnail avatar">
            </div>

            <div class="col-8">
               <h3>{{$user->name}}</h3>
            </div>
        </div>

        <div class="row">

            <div class="col-12">
                @commentForm(['route'=>route('users.comments.store', ['user'=>$user->id])]) @endcommentForm

                @commentsList(['comments'=>$user->commentsOn]) @endcommentsList
            </div>
        </div>
@endsection
