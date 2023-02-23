<p>
    @foreach ($tags as $tag)
        <a  class="badge badge-success" href="/posts/tag/{{$tag->id}}">{{$tag->name}}</a>
    @endforeach
</p>
