<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoiceOne = Invoice::create([
            'billToName' => 'John Smith',
            'billToAddr1' => '2 Court Square',
            'billToAddr2' => 'New York NY 12210',
            'dueDate' => '2022-1-1'
        ]);
        $invoiceOne->save();
        $invoiceOne->addProduct(1,20);
        $invoiceOne->addProduct(2,40);
        $invoiceOne->addProduct(3,30);

        $invoiceTwo = Invoice::create([
            'billToName' => 'Myles Carney',
            'billToAddr1' => '1352 Marie Street',
            'billToAddr2' => 'Bel Air MD 21014',
            'dueDate' => '2022-1-1'
        ]);
        $invoiceTwo->save();
        $invoiceTwo->addProduct(1,60);
        $invoiceTwo->addProduct(2,30);
        $invoiceTwo->addProduct(3,10);

        $invoiceThree = Invoice::create([
            'billToName' => 'Vivaan Burrows',
            'billToAddr1' => '522 Passaic Street',
            'billToAddr2' => 'Washington DC 20011',
            'dueDate' => '2022-1-1'
        ]);
        $invoiceThree->save();
        $invoiceThree->addProduct(1,120);
        $invoiceThree->addProduct(2,20);
        $invoiceThree->addProduct(3,120);
    }
}
