<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_community_page()
    {
        $community = Community::first();
        $response = $this->get('/c/' . $community->slug);

        $response->assertStatus(200);
    }
    public function test_post_page()
    {
        $post = Post::first();
        $response = $this->get('/post/' . $post->id);

        $response->assertStatus(200);
    }
}
