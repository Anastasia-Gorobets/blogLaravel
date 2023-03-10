<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


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
        return  view('posts.index',
            ['posts'=>BlogPost::latestWithRelations()->get()]);
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
        $validated['user_id'] = $request->user()->id;

        $post  = BlogPost::create($validated);

        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(Image::make(['path'=>$path]));
        }

        event(new BlogPostPosted($post));

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

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", now()->addSeconds(10), function () use ($id){
           /* return BlogPost::with('comments')->with('tags')->with('user')->with('comments.user')->findOrFail($id);*/

            return BlogPost::with('comments', 'tags', 'user','comments.user' )->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $userKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($userKey,[]);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session=>$lastVisit){
            if($now->diffInMinutes($lastVisit) >= 1){
                $difference--;
            }else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >= 1){
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;

        Cache::tags(['blog-post'])->forever($userKey,$usersUpdate);

        if(!Cache::tags(['blog-post'])->has($counterKey)){
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        }else{
            Cache::tags(['blog-post'])->increment($counterKey, $difference);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return  view('posts.show', [
            'post'=>$blogPost,
            'counter'=>$counter,
        ]);
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

        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');

            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path =  $path;
                $post->image->save();
            }else{
                $post->image()->save(Image::make(['path'=>$path]));
            }
        }

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
