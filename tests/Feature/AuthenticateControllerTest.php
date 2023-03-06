<?php

namespace Tests\Feature;

use Laravel\Passport\ClientRepository;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;


class AuthenticateControllerTest extends TestCase
{
    use DatabaseTransactions;


    /** @test */

    public function test_index_returns_authenticated_user()
    {

        $user = User::factory()->create();
        $accessToken = $user->createToken('test-token')->accessToken;

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'email' => $user->email,
        ]);
    }

    /** @test */

    public function test_user_can_register_and_get_access_token_with_client()
    {
        // En este test no solo comprobamos que se puede registrar, sino que ademas verificamos
        // que estamos usando el cliente de laravel Passport

        // Necesitamos un cliente para utilizar Laravel passport
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );

        // Creamos un usuario falso
        $user = User::factory()->make();

        // Y hacemos un request para registrar un usuario con esos datos
        $response = $this->postJson('/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password'
        ]);


        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);


        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);

        // Nos aseguramos de que el token fue generado para el usuario
        $token = $response->json('token');
        Passport::actingAsClient($client);
        $this->assertNotNull($token);
        $this->assertTrue($client->personal_access_client);
        $this->assertEquals($user->id, auth()->id());
    }

    /** @test */

    public function test_login_returns_token()
    {

        // Si no se utiliza el metodo hash, el test dará error... porque hay un check en el controlador
        $user = User::factory()->create([
            'name' => 'Alessandro',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        // Con el usuario creado, hacemos login(post)
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        // DD(Dump and die) Digamos que es un console.log, para ver la respuesta del login, si el test diese error
        // quitariamos el comentario para asegurar que nos da login success o error, pero hay que asegurarse
        // de que el error viene antes de esta linea, porque una vez se hace este comando, se termina el test

        // dd($response->json());

        $token = $response->json('token');
        $this->assertNotNull($token);

        // Make a request to the /api/user endpoint with the token and assert the response
        $this->actingAs($user)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])
            ->get('/api/user')
            ->assertStatus(200)
            ->assertJsonFragment([
                'email' => $user->email,
            ])
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]);
    }

    /** @test */

    public function test_logout_revokes_access_token()
    {

        $user = User::factory()->create();

        $accessToken = $user->createToken('Test Token')->accessToken;

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken
        ];

        $response = $this->post('/api/logout', [], $headers);

        $response->assertStatus(200);

        // la propiedad revoked es un booleano, entonces si el numero es 1(al cual estamos haciendo assert)
        // significa que el token ha sido eliminado con éxito, si se pone 0, el test debería de fallar

        $this->assertEquals(1, $user->tokens()->first()->revoked);
    }

    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();
        $accessToken = $user->createToken('Test Token')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json'
        ])->json('PUT', '/api/user/' . $user->id, [
            'name' => 'New Name',
            'password' => 'newpassword'
        ]);
        // como anteriomente, usamos este comando para ver la respuesta, si fallase quitamos el comentario para
        // tener más contexto del error
        // dd($response->json());
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name'
        ]);
    }

    /** @test */

    public function test_user_can_be_destroyed()
    {
        $user = User::factory()->create();
        $accessToken = $user->createToken('Test Token')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json'
        ])
            ->json('DELETE', '/api/delete', [
                'email' => $user->email,
                'password' => 'password'
            ]);
        $response->assertRedirect('/home');
        $this->assertEquals(1, User::where('id', $user->id)->delete());
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
