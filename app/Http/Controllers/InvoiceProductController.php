<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceProducts;


class InvoiceProductController extends Controller
{

    private $validations = [
        'amount' => 'required|numeric|min:1',
    ];

    public function update(Request $request, Invoice $invoice, InvoiceProducts $invoiceProduct)
    {
        $validated = $request->validate($this->validations);
        $invoiceProduct->update($validated);
        $invoiceProduct->save();
        return $invoiceProduct;
    }
}
