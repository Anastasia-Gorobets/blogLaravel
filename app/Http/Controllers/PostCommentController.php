<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostComment;
use App\Models\BlogPost;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, PostComment $request){
        $comment = $post->comments()->create([
            'content'=>$request->input('content'),
            'user_id'=>$request->user()->id,
         ]
        );

        event(new \App\Events\CommentPosted($comment));

        return redirect()->back()->withStatus('Comment was created!');
    }



}
