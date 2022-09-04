<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ChatroomControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_found()
    {
        $response = $this->get(route('room.view'));

        $response->assertStatus(302);
    }

    public function test_index_success()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $this->actingAs($user)->get(route('room.view'))->assertStatus(200)->assertViewIs('chatroom.room');

        $user->delete();
    }
}
