<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Invitation;

class InvitationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_show()
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

        $response = $this->getJson('/api/public/invitations/wedding-slug');

        $response->assertStatus(200)
                 ->assertJson(['data' => ['slug' => 'wedding-slug']]);
    }

    public function test_index_requires_auth()
    {
        $response = $this->getJson('/api/invitations');

        $response->assertStatus(401);
    }

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

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/api/invitations');

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

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'title' => 'New Invitation',
            'bride_name' => 'Bride',
            'groom_name' => 'Groom',
            'date' => '2026-1-31',
            'time' => '10:00',
            'city' => 'Jakarta',
            'address' => 'Venue Address',
            'template' => 'template1',
            'slug' => 'new-slug',
            'cover_image' => 'https://example.com/image.jpg',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->postJson('/api/invitations', $data);

        $response->assertStatus(201)
                 ->assertJson(['data' => ['title' => 'New Invitation']]);

        $this->assertDatabaseHas('invitations', ['title' => 'New Invitation']);
    }

    public function test_show()
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

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/api/invitations/' . $invitation->id);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['id' => $invitation->id]]);
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

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = ['title' => 'Updated Title'];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->putJson('/api/invitations/' . $invitation->id, $data);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['title' => 'Updated Title']]);

        $this->assertDatabaseHas('invitations', ['title' => 'Updated Title']);
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

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->deleteJson('/api/invitations/' . $invitation->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('invitations', ['id' => $invitation->id]);
    }
}