<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        // seed the database
       $this->seed();
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
        $data = ['billToName' => 'Steve Smith', 
        'billToAddr1' => '2 Court Square',
        'billToAddr2' => 'New York NY 12210',
        'dueDate' => '10/09/2021',
        'products' => '[]' ];
        $response = $this->post("/invoice", $data);
        $this->assertDatabaseHas('invoices', ['billToName' => 'Steve Smith']);
    }

    public function test_remove()
    {
        $data = ['billToName' => 'Steve Smith', 
        'billToAddr1' => '2 Court Square',
        'billToAddr2' => 'New York NY 12210',
        'dueDate' => '10/09/2021' ];
        $response = $this->post("/invoice", $data);
        $this->assertDatabaseHas('invoices', ['id'=>1]);
        $response = $this->delete("/invoice/1");
        $this->assertDatabaseMissing('invoices',['id'=>1]);
    }

    public function test_edit()
    {
        $data = ['billToName' => 'Steve Smith', 
        'billToAddr1' => '2 Court Square',
        'billToAddr2' => 'New York NY 12210',
        'dueDate' => '2022-09-10',
        'products' => '[]' ];
        $dataUpdated = ['billToName' => 'Steve Bob', 
        'billToAddr1' => '3 Court Square',
        'billToAddr2' => 'New York NY 14210',
        'dueDate' => '2022-09-20' ];
        $response = $this->post("/invoice", $data);
        $this->assertDatabaseHas('invoices', ['billToName' => 'Steve Smith']);
        $response = $this->put("/invoice/4",$dataUpdated);
        $this->assertDatabaseHas('invoices',['billToName' => 'Steve Bob']);
        $this->assertDatabaseMissing('invoices', ['billToName' => 'Steve Smith']);
    }
}
