<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggeble;

class Comment extends Model
{
    use HasFactory;

    use SoftDeletes, Taggeble;

    protected $fillable = ['user_id','content'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new LatestScope);



        static::creating(function (Comment $comment){
            if($comment->commentable_type === BlogPost::class){
                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
                Cache::tags(['blog-post'])->forget("mostCommentedPosts");
                Cache::tags(['blog-post'])->forget("mostActive");
                Cache::tags(['blog-post'])->forget("mostActiveLastMonth");
            }

        });


    }




    public function scopeLatest(Builder $query)
    {
        $query->orderBy(static::CREATED_AT,'desc');

    }
}
