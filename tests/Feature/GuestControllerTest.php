<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Guest;

class GuestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
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

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/api/invitations/' . $invitation->id . '/guests');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

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

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'name' => 'New Guest',
            'phone' => '987654321',
            'email' => 'newguest@example.com',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->postJson('/api/invitations/' . $invitation->id . '/guests', $data);

        $response->assertStatus(201)
                 ->assertJson(['data' => ['name' => 'New Guest']]);

        $this->assertDatabaseHas('guests', ['name' => 'New Guest']);
    }

    public function test_update()
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

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = ['name' => 'Updated Guest'];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->putJson('/api/invitations/' . $invitation->id . '/guests/' . $guest->id, $data);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['name' => 'Updated Guest']]);

        $this->assertDatabaseHas('guests', ['name' => 'Updated Guest']);
    }

    public function test_destroy()
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

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->deleteJson('/api/invitations/' . $invitation->id . '/guests/' . $guest->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('guests', ['id' => $guest->id]);
    }
}