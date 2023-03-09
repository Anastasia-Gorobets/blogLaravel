<style>
    body{
        color: #2d3748;
    }
</style>

<h1>Hi {{$comment->commentable->user->name}}</h1>
<p>
   Comment was posted on post you're watching <a href="{{route('posts.show', ['post'=>$comment->commentable->id])}}">{{$comment->commentable->title}}</a>
</p>

<hr>
<p>
    <img src="{{$comment->user->image ? $message->embed($comment->user->image->url()) : ''}}">
    <a href="{{route('users.show', ['user'=>$comment->user->id])}}">{{$comment->user->name}}</a> said:
</p>

<p>
    {{$comment->content}}
</p>

