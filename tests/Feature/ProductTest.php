<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{

    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
        // alternatively you can call
        // $this->seed();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_seeder()
    {
        $tm = Product::firstWhere('name','Training Minutes');
        $this->assertEquals(5.99,$tm->price);
    }

    public function test_add()
    {
        $data = ['name' => 'Testing Minutes', 'price' => '10.80'];

        $this->assertDatabaseMissing('products', $data);
        $response = $this->post("/products", $data);
        $this->assertDatabaseHas('products', $data);

    }

    public function test_remove()
    {
        $this->assertDatabaseHas('products', ['id' => 1]);
        $response = $this->delete("/products/1");
        $this->assertDatabaseMissing('products', ['id' => 1]);
    }

    public function test_edit()
    {
        $data = ['name' => 'DevMinutes', 'price' => '35.99'];
        $dataEdited = ['name' => 'DevMinutes', 'price' => '45.99'];
        $this->assertDatabaseHas('products', $data);
        $response = $this->put('/products/1', $dataEdited);
        $this->assertDatabaseHas('products', $dataEdited);
        $this->assertDatabaseMissing($data);
    }

    public function test_view_valid()
    {
        $response->get('/products/1');
        $response->assertStatus(200);
    }

    public function test_view_nonExistant()
    {
        $response->get('/products/10');
        $response->assertStatus(404);
    }

    public function test_edit_valid()
    {
        $response->get('/products/1/edit');
        $response->assertStatus(200);
    }

    public function test_edit_nonExistant()
    {
        $response->get('/products/10/edit');
        $response->assertStatus(404);
    }

    public function test_index_200()
    {
        $response->get('/products');
        $response->assertStatus(200);
    }
}
