<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Model;
use App\Models\User;
use Faker\Factory;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ModelTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_model_list_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $brand = Model::factory()->create();
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/models');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_model_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $faker = Factory::create();
        $brand = Brand::factory()->create();

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/models', [
            'name' => $faker->name,
            'brand_id' => $brand->id,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destroy_model_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            );
        $model = Model::factory()->create();
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete('/api/models/'.$model->id);

        $response->assertStatus(204);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_model_validation_error()
    {
        Sanctum::actingAs(User::factory()->create());

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/models', [
            'name' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_put_model_validation_error()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        $model = Model::factory()->create();

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/brands/'.$model->id, [
            'name' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_model_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/models', []);

        $response->assertStatus(401);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_put_model_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/models/12', []);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destroy_model_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete('/api/models/12', []);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_models_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/models/12', []);

        $response->assertStatus(401);
    }
}
