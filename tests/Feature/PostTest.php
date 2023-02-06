<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
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


    public function testSee1BlogPostWhithComments()
    {
        $post = $this->createBlogPost();

        Comment::factory(4)->create(['blog_post_id'=>$post->id]);

        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $user = $this->user();
        $this->actingAs($user);

        $params = [
            'title'=>'Title2 test',
            'content'=>'Content2 test content',
        ];
        $this->post('/posts',$params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was created!');
    }


    public function testStoreFail()
    {
        $user = $this->user();
        $this->actingAs($user);
        $params = [
            'title'=>'x',
            'content'=>'x',
        ];
        $this->post('/posts',$params)->assertStatus(302)->assertSessionHas('errors');
    }


    public function testUpdateValid()
    {
        $user = $this->user();

        $this->actingAs($user);

        $post = $this->createBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', ['title'=>$post->title]);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed',
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog Post was updated!');
        $this->assertDatabaseMissing('blog_posts',['title'=>'Title1']);

    }

    public function testDeleteValid()
    {
        $user = $this->user();

        $this->actingAs($user);

        $post = $this->createBlogPost($user->id);

        $this->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was deleted!');

        $this->get('/posts')->assertDontSee('Title1');
    }

    private function createBlogPost($userId = null){
        return BlogPost::factory()->newTitle()->create(['user_id'=>$userId ?? $this->user()->id]);
    }



}
