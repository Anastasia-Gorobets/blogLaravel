<div class="container">
    <div class="row">
        <div class="col">
            @card(['title'=>trans('messages.most_commented_posts')])
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
