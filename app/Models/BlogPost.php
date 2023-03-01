<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BlogPost extends Model
{
    protected $fillable = ['title','content', 'user_id'];
    use HasFactory;

    use SoftDeletes;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function image(){
        return $this->morphOne(Image::class, 'imagebale');
    }


    public static  function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        static::deleting(function (BlogPost $blogPost){
            if($blogPost->image){
                Storage::delete($blogPost->image->path);
            }
            $blogPost->comments()->delete();
            $blogPost->image()->delete();

            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::restoring(function (BlogPost $blogPost){
            $blogPost->comments()->restore();
        });

        static::updating(function (BlogPost $blogPost){
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

       // static::addGlobalScope(new LatestScope);
    }


    public function scopeLatest(Builder $query)
    {
        $query->orderBy(static::CREATED_AT,'desc');

    }
    public function scopeLatestWithRelations(Builder $query)
    {
        $query->latest()->withCount('comments')->with('user')->with('tags');
    }


    public function scopeMostCommented(Builder $query)
    {
        $query->withCount('comments')->orderBy('comments_count','desc');

    }





}
