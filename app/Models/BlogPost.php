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
use App\Traits\Taggeble;

class BlogPost extends Model
{
    protected $fillable = ['title','content', 'user_id'];
    use HasFactory;

    use SoftDeletes, Taggeble;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function image(){
        return $this->morphOne(Image::class, 'imagebale');
    }


    public static  function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

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
