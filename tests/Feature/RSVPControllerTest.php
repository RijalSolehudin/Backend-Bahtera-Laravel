<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Guest;
use App\Models\RSVP;

class RSVPControllerTest extends TestCase
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

        $guest = Guest::create([
            'invitation_id' => $invitation->id,
            'name' => 'Guest Name',
            'phone' => '123456789',
            'email' => 'guest@example.com',
        ]);

        $data = [
            'guest_id' => $guest->id,
            'status' => 'attending',
            'people_count' => 2,
            'message' => 'Excited to attend!',
        ];

        $response = $this->postJson('/api/invitations/wedding-slug/rsvp', $data);

        $response->assertStatus(201)
                 ->assertJson(['data' => ['status' => 'attending']]);

        $this->assertDatabaseHas('rsvps', ['status' => 'attending']);
    }
}