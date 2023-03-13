<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const LOCALES = [
        'en'=>'English',
        'es'=>'Spanish',
        'de'=>'Deautch'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);

    }

    public function image(){
        return $this->morphOne(Image::class, 'imagebale');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsOn()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function scopeWithMostBlogPosts(Builder $query)
    {
        $query->withCount('blogPosts')->orderBy('blog_posts_count','desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        $query->withCount(['blogPosts'=>function($query){
            return $query->whereBetween(static::CREATED_AT, [now()->subMonth(3), now()]);
        }])
            ->has('blogPosts','>=',2)
            ->orderBy('blog_posts_count','desc');
    }

    public function scopeThatHasCommentedPost(Builder $query, BlogPost $blogPost){

          $query->whereHas('comments', function ($query) use ($blogPost) {
            return $query->where('commentable_id', '=', $blogPost->id)
                ->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeThatIsAdmin(Builder $query){

        $query->where('is_admin',true);

    }


}
