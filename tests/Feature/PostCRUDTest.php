<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PostCRUDTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'sqlite']);

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
    }
    /**
     * A basic feature test example.
     */
    public function test_create_post_admin()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $this->actingAs($user);

        $response = $this->post('/posts',[
            'title' => 'title',
            'body' => 'body',
            'author' => $user->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_create_post_editor(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Editor');
        $permission = Permission::findOrCreate('Post:create');
        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $response = $this->post('/posts',[
            'title' => 'title',
            'body' => 'body',
            'author' => $user->id,
        ]);

        $response->assertRedirect('/posts');
    }

    public function test_create_post_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $this->actingAs($user);

        $response = $this->post('/posts',[
            'title' => 'title',
            'body' => 'body',
            'author' => $user->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_edit_post_with_admin()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author' => $user->id,
        ]);
        $user->assignRole('Admin');

        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'title2',
        ]);

        $response->assertStatus(403);
    }

    public function test_edit_post_with_editor()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author' => $user->id,
        ]);
        $user->assignRole('Editor');
        $permission = Permission::findOrCreate('Post:update');
        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'title2',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'title2',
            'author' => $user->id
        ]);
    }

    public function test_edit_post_with_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author' => $user->id,
        ]);
        $user->assignRole('User');

        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'title2',
        ]);

        $response->assertStatus(403);
    }

    public function test_delete_post_with_admin()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author' => $user->id,
        ]);

        $user->assignRole('Admin');

        $permission = Permission::findOrCreate('Post:delete');
        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post->id));
        $this->assertTrue($user->can('Post:delete', $user));
        $response->assertStatus(302);
    }
    public function test_delete_post_with_editor()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author' => $user->id,
        ]);

        $user->assignRole('Editor');

        $permission = Permission::findOrCreate('Post:delete');
        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post->id));
        $this->assertTrue($user->can('Post:delete', $user));
        $response->assertStatus(302);
    }
    public function test_delete_post_with_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author' => $user->id,
        ]);
        $user->assignRole('User');

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post->id));

        $response->assertStatus(403);
    }
}
