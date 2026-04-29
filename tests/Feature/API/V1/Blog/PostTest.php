<?php

use App\Enums\PostError;
use App\Enums\PostEvent;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });

uses(RefreshDatabase::class);

it('creates a post with the correct structure', function () {
    $payload = [
        'title'   => 'Pest Test Post',
        'content' => 'Content for Pest testing.'
    ];

    $response = $this->postJson('/api/v1/blog/posts', $payload);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'code'    => PostEvent::POST_CREATED->value,
        ])
        // Verify the exact data structure required in your TAF
        ->assertJsonStructure([
            'success',
            'code',
            'data' => ['id', 'title', 'content', 'status', 'created_at', 'published_at', 'moderated_at']
        ]);

    $this->assertDatabaseHas('posts', ['title' => 'Pest Test Post']);
});

it('validates required fields and returns errorFields', function () {
    $response = $this->postJson('/api/v1/blog/posts', []);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'code'    => 'VALIDATION_ERROR'
        ])
        ->assertJsonStructure(['errorFields' => ['title', 'content']]);
});

it('can filter posts by status', function () {
    // Create posts with different statuses using a Factory
    Post::factory()->create(['status' => 'published']);
    Post::factory()->create(['status' => 'moderation']);

    $response = $this->getJson('/api/v1/blog/posts?status=published');

    $response->assertOk()
        ->assertJsonCount(1, 'data');
});

it('returns a 404 error in the correct format if post is not found', function () {
    $response = $this->getJson('/api/v1/blog/posts/999');

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'code'    => PostError::POST_NOT_FOUND->value,
            'data'    => []
        ]);
});

it('soft deletes a post', function () {
    $post = Post::factory()->create();

    $response = $this->deleteJson("/api/v1/blog/posts/{$post->id}");

    $response->assertOk();
    
    // The record should be "deleted" but still exist in DB (Soft Delete)
    $this->assertSoftDeleted('posts', ['id' => $post->id]);
});
