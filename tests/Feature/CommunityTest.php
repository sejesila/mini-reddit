<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_list_of_my_communities()
    {
        //create user
        $user = User::withCount('communities')->has('communities')->first();
        //login with that user
        auth()->login($user);
        //create a community
        //load communities list
        $response = $this->get('/communities');
        $response->assertStatus(200);

//        dd($user->communities_count . '-' . substr_count($response->getContent(),'community-item'));

        $this->assertEquals($user->communities_count,substr_count($response->getContent(),'community-item'));
    }

    public function testCreateCommunity()
    {
        //create user
        $user = User::first();
        //login with that user
        auth()->login($user);
        //create community
        $response = $this->post('/communities',[
            'name' => 'Some unique name 98765',
            'description'=>'Classy desc 98765'
        ]);
        //redirect
        $response->assertStatus(302);

        //load communities list
        $response = $this->get('/communities');
        $response->assertStatus(200);

        $this->assertStringContainsString('Some unique name 98765',$response->getContent());
    }
}
