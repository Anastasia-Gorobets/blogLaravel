<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNewBlogPostDoesNotHaveComments()
    {
        BlogPost::factory(1)->create(['user_id'=>$this->user()->id]);
        $response = $this->json('GET', '/api/v1/post/1/comments');
        $response->assertStatus(200)->assertJsonStructure(['data','links']);
    }

    public function testBlogPostHas10Comments()
    {
        $post = $this->createBlogPost();
        $user = $this->user();

        Comment::factory(10)->create(['commentable_id'=>$post->id, 'commentable_type'=>BlogPost::class, 'user_id'=>$user->id]);


        $response = $this->json('GET', '/api/v1/post/2/comments');


        $response->assertStatus(200)->assertJsonStructure(['data','links'])->assertJsonCount(10,'data');
    }


    public function testAddingNewBlogPostCommentWhithoutAuth(){
        $this->createBlogPost();
        $response = $this->json('POST', '/api/v1/post/3/comments', [
            'content'=>'Test content'
        ]);
        $response->assertStatus(401);
    }

    public function testAddingNewBlogPostCommentWhithAuth(){
        $this->createBlogPost();
        $response = $this->actingAs($this->user())->json('POST', '/api/v1/post/4/comments', [
            'content'=>'Test content'
        ]);
        $response->assertStatus(200);
    }



    private function createBlogPost($userId = null){
        return BlogPost::factory()->newTitle()->create(['user_id'=>$userId ?? $this->user()->id]);
    }


}
