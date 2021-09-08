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
}
