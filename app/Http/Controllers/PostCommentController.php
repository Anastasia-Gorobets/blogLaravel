<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostComment;
use Illuminate\Http\Request;
use App\Models\BlogPost;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, PostComment $request){
        $post->comments()->create([
            'content'=>$request->input('content'),
            'user_id'=>$request->user()->id,
         ]
        );
        $request->session()->flash('status', 'Comment was created!');
        return redirect()->back();
    }



}
