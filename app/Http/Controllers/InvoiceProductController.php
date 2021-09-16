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

    public function destroy(Request $request, Invoice $invoice, InvoiceProducts $invoiceProduct)
    {
        $invoiceProduct->delete();
        return ['success' => true];
    }

    public function store(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'product_id' => 'required|numeric']);

        $p = Product::where('id', '=', $validated['product_id'])->first();
        if ($p === null) {
            abort(422);
        };
        return $invoice->addProduct(
            $validated['product_id'],
            $validated['amount'],
        );
    }
}
