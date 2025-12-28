<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Wish;

class WishControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $invitation = Invitation::create([
            'user_id' => $user->id,
            'title' => 'Wedding Invitation',
            'bride_name' => 'Bride',
            'groom_name' => 'Groom',
            'date' => '2025-12-31',
            'time' => '10:00',
            'city' => 'Jakarta',
            'address' => 'Venue Address',
            'template' => 'template1',
            'slug' => 'wedding-slug',
            'cover_image' => 'image.jpg',
        ]);

        $data = [
            'name' => 'Well Wisher',
            'message' => 'Congratulations!',
        ];

        $response = $this->postJson('/api/invitations/wedding-slug/wish', $data);

        $response->assertStatus(201)
                 ->assertJson(['data' => ['message' => 'Congratulations!']]);

        $this->assertDatabaseHas('wishes', ['message' => 'Congratulations!']);
    }
}