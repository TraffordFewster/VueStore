<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/invoice');
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $data = ['billToName' => 'John Smith', 
        'billToAddr1' => '2 Court Square',
        'billToAddr2' => 'New York NY 12210',
        'Due' => '10/09/2021' ];
        $response = $this->post("/invoice", $data);
        $this->assertDatabaseHas('invoices', $data);
    }

    public function test_remove()
    {
        $data = ['billToName' => 'John Smith', 
        'billToAddr1' => '2 Court Square',
        'billToAddr2' => 'New York NY 12210',
        'Due' => '10/09/2021' ];
        $response = $this->post("/invoice", $data);
        $this->assertDatabaseHas('invoices', ['id'=>1]);
        $response = $this->delete("/invoice/1");
        $this->assertDatabaseMissing('invoices',['id'=>1]);
    }

    public function test_edit()
    {
        $data = ['billToName' => 'John Smith', 
        'billToAddr1' => '2 Court Square',
        'billToAddr2' => 'New York NY 12210',
        'Due' => '10/09/2021' ];
        $dataUpdated = ['billToName' => 'John Bob', 
        'billToAddr1' => '3 Court Square',
        'billToAddr2' => 'New York NY 14210',
        'Due' => '10/09/2022' ];
        $response = $this->post("/invoice", $data);
        $this->assertDatabaseHas('invoices', $data);
        $response = $this->put("/invoice/1",$dataUpdated);
        $this->assertDatabaseHas('invoices',$dataUpdated);
        $this->assertDatabaseMissing('invoices', $data);
    }
}
