<?php

namespace Tests\Feature;
use Laravel\Passport\ClientRepository;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

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

public function test_user_can_register_and_get_access_token()
    {
        // Necesitamos un cliente para utilizar Laravel passport
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
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

}
