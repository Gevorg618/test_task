<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_brand_list_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/brands');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'models',
                ]
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_brand_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $faker = Factory::create();

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/brands', [
            'name' => $faker->name,
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
    public function test_put_brand_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        $faker = Factory::create();
        $brand = Brand::factory()->create();

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/brands/'.$brand->id, [
            'name' => $faker->name,
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destroy_brand_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        $brand = Brand::factory()->create();
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete('/api/brands/'.$brand->id);

        $response->assertStatus(204);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_brand_validation_error()
    {
        Sanctum::actingAs(User::factory()->create());

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/brands', [
            'name' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_put_brand_validation_error()
    {
        Sanctum::actingAs(User::factory()->create());

        $brand = Brand::factory()->create();

        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/brands/'.$brand->id, [
            'name' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_brand_list_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/brands');

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_brand_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/brands', []);

        $response->assertStatus(401);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_put_brand_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/brands/12', []);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_destroy_brand_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete('/api/brands/12', []);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_brand_for_non_authenticated_user()
    {
        $response =  $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/brands/12', []);

        $response->assertStatus(401);
    }
}
