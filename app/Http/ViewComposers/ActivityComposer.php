<?php

namespace App\Http\ViewComposers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view){

        $mostCommented = Cache::tags(['blog-post'])->remember('mostCommentedPosts', now()->addSeconds(200), function (){
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember('mostActive', now()->addSeconds(10), function (){
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth', now()->addSeconds(10), function (){
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommentedPosts',$mostCommented);
        $view->with('mostActive',$mostActive);
        $view->with('mostActiveLastMonth',$mostActiveLastMonth);
    }

}
