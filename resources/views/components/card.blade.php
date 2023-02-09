<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{$title}}</h5>
        <ul>
            @if(is_a($items, 'Illuminate\Support\Collection'))
            @foreach($items as $key=>$item)
                <li>
                    {{$item}}
                </li>
            @endforeach
            @else
                {{$items}}
            @endif
        </ul>
    </div>
</div>


{{--
<a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a>--}}
