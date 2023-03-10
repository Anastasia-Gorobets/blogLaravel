<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();
        if(0 === $tagCount){
            $this->command->info('No tags found');
            return;
        }
        $howManyMin = (int)$this->command->ask('Min tags?', 0);
        $howManyMax = min((int)$this->command->ask('Max tags?', $tagCount), $tagCount);
        $posts = BlogPost::all();
        $posts->each(function (BlogPost $post) use ($howManyMin, $howManyMax){
            $take = random_int($howManyMin, $howManyMax);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
            $post->tags()->sync($tags);
        });

    }
}
