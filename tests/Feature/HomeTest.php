<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertSeeText('Index');
        $response->assertSeeText('Laravel App');
    }
    public function testContact()
    {
        $response = $this->get('/contact');
        $response->assertSeeText('Contact');
    }
}
