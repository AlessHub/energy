<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\Forum;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class ForumControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }


    /** @test */
    public function test_non_authenticated_user_cannot_access_list_of_forums()
    {
        $response = $this->getJson(route('forums.index'));

        $response->assertStatus(401);
    }

    /** @test */
    public function it_returns_a_list_of_forums_for_an_authenticated_user()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $forum = Forum::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson(route('forums.index'), [
            'Authorization' => 'Bearer ' . $user->createToken('Test Token')->accessToken
        ]);

        $response->assertStatus(201);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'title' => $forum->title,
            'description' => $forum->description,
            'cover' => $forum->cover,
            'autor' => $forum->autor,
            'user_id' => $forum->user_id,
        ]);
    }

    public function test_non_authenticated_user_cannot_access_forum()
{
    $forum = Forum::factory()->create();

    $response = $this->getJson(route('forums.show', $forum->id));

    $response->assertStatus(401);
}



// Test muy parecido al anterior, pero en vez de probar el index, testeamos el 
// show, con el id para ver un foro especifico, para probar que falla, es decir, que funciona
// se puede quitar el id de la ruta en la linea 71 y dará error al no tener el parametro que define lo que
// queremos ver

/** @test */
public function test_it_returns_a_forum_for_an_authenticated_user()
{
    $user = User::factory()->create();
    Passport::actingAs($user);

    $forum = Forum::factory()->create();

    $response = $this->getJson(route('forums.show', ['forum' => $forum->id]), [
        'Authorization' => 'Bearer ' . $user->createToken('Test Token')->accessToken
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id',
        'title',
        'description',
        'cover',
        'autor',
        'created_at',
        'updated_at',
    ]);
}

public function test_non_authenticated_users_cannot_create_forums()
{
    $response = $this->postJson(route('forums.store'), [
        'title' => $this->faker->sentence(),
        'description' => $this->faker->paragraph(),
        'cover' => 'https://example.com/cover-image.jpg',
        'autor' => $this->faker->name(),
    ]);

    $response->assertStatus(401);
}


    /** @test */
    public function it_requires_a_cover_to_create_a_forum_for_an_authenticated_user()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->postJson(route('forums.store'), [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'autor' => $this->faker->name(),
        ], [
            'Authorization' => 'Bearer ' . $user->createToken('Test Token')->accessToken
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('cover');
    }


    /** @test */
    public function test_store_forum_without_uploading_image()
{
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->accessToken;

    $formData = [
        'title' => 'Test Forum',
        'description' => 'This is a test forum',
        'autor' => 'Test User',
        'cover' => 'An image'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token
    ])->postJson('/api/forums', $formData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message'
        ]);

    $this->assertDatabaseHas('forums', [
        'title' => $formData['title'],
        'description' => $formData['description'],
        'autor' => $formData['autor'],
        'user_id' => $user->id,
        'cover' => $formData['cover']
    ]);
}

    


}
