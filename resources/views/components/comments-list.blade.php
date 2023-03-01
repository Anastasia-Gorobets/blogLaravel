<h4>Comments</h4>
@forelse($comments as $comment)
    <p>{{$comment->content}}</p>
    @updated(['date'=>$comment->created_at->diffForHumans(), 'name'=>$comment->user->name, 'userId'=>$comment->user->id])
    @endupdated
@empty
    <p>No comments yet!</p>
@endforelse
