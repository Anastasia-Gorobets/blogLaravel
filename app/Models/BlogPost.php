<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    protected $fillable = ['title','content', 'user_id'];
    use HasFactory;

    use SoftDeletes;

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static  function boot()
    {
        parent::boot();

        static::deleting(function (BlogPost $blogPost){
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost){
            $blogPost->comments()->restore();
        });

       // static::addGlobalScope(new LatestScope);
    }


    public function scopeLatest(Builder $query)
    {
        $query->orderBy(static::CREATED_AT,'desc');

    }


    public function scopeMostCommented(Builder $query)
    {
        $query->withCount('comments')->orderBy('comments_count','desc');

    }





}
