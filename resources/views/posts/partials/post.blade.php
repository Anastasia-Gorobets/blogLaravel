<h3><a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a></h3>

<p>{{trans_choice('messages.comments',$post->comments_count)}}</p>

<div class="mb-3">

    @auth
    @can('update', $post)
     <a class="btn btn-primary" href="{{route('posts.edit',['post'=>$post->id])}}">Edit</a>
    @endcan

        @if(!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" method="POST"  action="{{route('posts.destroy', ['post'=>$post->id])}}">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-primary" type="submit" value="Delete">
                </form>
            @endcan
        @endif
    @endauth

</div>

