@extends('layouts.app')

@section('title','Create the post')

@section('content')
    <form method="POST" action="{{route('posts.store')}}">
        @csrf
        <div>
            <input type="text" name="title" value="{{ old('title') }}">
            @error('title')
             <div>Please fill title</div>
            @enderror
        </div>
        <div>
            <textarea name="content">{{ old('content') }}</textarea>
        </div>

        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
         <div>
            <input type="submit" value="Create">
        </div>
    </form>
@endsection