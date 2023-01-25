<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{

    use RefreshDatabase;

    public function testNoBlogPosts()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        $post = $this->createBlogPost();

        $response = $this->get('/posts');
        $response->assertSeeText('Title1');
        $response->assertSeeText('No comments yet');
        $this->assertDatabaseHas('blog_posts',['title'=>'Title1']);
    }

    public function testStoreValid()
    {
        $params = [
            'title'=>'Title2 test',
            'content'=>'Content2 test content',
        ];
        $this->post('/posts',$params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was created!');
    }


    public function testStoreFail()
    {
        $params = [
            'title'=>'x',
            'content'=>'x',
        ];
        $this->post('/posts',$params)->assertStatus(302)->assertSessionHas('errors');
    }


    public function testUpdateValid()
    {
        $post = $this->createBlogPost();

        $this->assertDatabaseHas('blog_posts',['title'=>'Title1']);

        $params = [
            'title'=>'Title1 updated',
            'content'=>'Content1 updated',
        ];
        $this->put("/posts/{$post->id}",$params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was updated!');
        $this->assertDatabaseMissing('blog_posts',['title'=>'Title1']);

    }

    public function testDeleteValid()
    {
        $post = $this->createBlogPost();
        $this->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was deleted!');
        $this->assertDatabaseMissing('blog_posts',['title'=>'Title1']);
    }

    private function createBlogPost(){
        $post = new BlogPost();
        $post->title = 'Title1';
        $post->content = 'Content1';
        $post->save();

        return $post;
    }



}
