<div @if(!$loop->even)style="background-color: silver" @endif>
    {{$loop->index}} {{$post->title}}
</div>
<div>
    <form method="POST"  action="{{route('posts.destroy', ['post'=>$post->id])}}">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">
    </form>
</div>
