<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'edit', 'store', 'update', 'destroy']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       /* $posts = BlogPost::withCount(['comments', 'comments as new_comments'=>function($query){
            $query->where('created_at','>=', '2023-01-24 18:00:08');
        }])->get();*/


         /*$posts = BlogPost::whereDoesntHave('comments', function($query){
             $query->where('content', 'like', '%abc%');
         })->get();*/



       /* $posts = BlogPost::whereHas('comments',function($query){
            $query->where('content', 'like', '%abc%');
        })->get();

        dd($posts);*/

        //$posts = BlogPost::with('comments')->get();
        return  view('posts.index',['posts'=>BlogPost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', BlogPost::class);

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
//        $post = new BlogPost();
//        $post->title = $validated['title'];
//        $post->content = $validated['content'];
//        $post->save();

        $post  = BlogPost::create($validated);

        $request->session()->flash('status', 'Blog Post was created!');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  view('posts.show', ['post'=>BlogPost::with('comments')->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
       /* if(Gate::denies('update-post',$post)){
            abort(403);
        }*/

        $this->authorize('update',$post);

        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        /*if(Gate::denies('update-post',$post)){
            abort(403);
        }*/

        $this->authorize('update',$post);

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog Post was updated!');
        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $post = BlogPost::findOrFail($id);
       $this->authorize('delete',$post);
       $post->delete();
       session()->flash('status', 'Blog Post was deleted!');
       return redirect()->route('posts.index');
    }
}
