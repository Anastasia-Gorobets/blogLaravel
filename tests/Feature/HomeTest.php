<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;



class HomeTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex()
    {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertSeeText('You are logged in!');
        $response->assertSeeText('Dashboard');
    }
    public function testContact()
    {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->get('/contact');
        $response->assertSeeText('Contact');
    }
}
