<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user registration
     *
     * @return void
     */
    public function test_user_register_successful_response()
    {
        $faker = Factory::create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/register', [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->password
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'token',
                ]
            ]);
    }

    /**
     * Test user login
     *
     * @return void
     */
    public function test_user_login_successful_response()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/brands');

        $response->assertOk();
    }

    /**
     * Test user registration validation response
     *
     * @return void
     */
    public function test_user_register_validation_error_response()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/register', []);

        $response->assertStatus(422);
    }

    /**
     * Test user login
     *
     * @return void
     */
    public function test_user_login_validation_error_response()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/register', []);

        $response->assertStatus(422);
    }

}
