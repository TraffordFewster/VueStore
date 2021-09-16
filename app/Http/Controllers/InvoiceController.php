<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{

    private $validations = [
        'billToName' => 'required|max:255|min:3',
        'billToAddr1' => "required|max:255|min:3",
        'billToAddr2' => "required|max:255|min:3",
        'dueDate' => "required|date|after:today",
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Invoice::all();
        $products = Product::all();
        $data->load(['products']);
        return view('invoice.index',compact("data","products"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'billToName' => 'required|max:255|min:3',
        'billToAddr1' => "required|max:255|min:3",
        'billToAddr2' => "required|max:255|min:3",
        'dueDate' => "required|date|after:today",
        'products' => "required|json",
        ]);
        $products = json_decode($validated['products']);
        
        foreach ($products as $key => $value) { // This should be done with a validator but this project is mainly for Vue not Laravel.
            if ($value->amount <= 0) {
                abort(422);
            };
            if (! Product::find($value->productid)) {
                abort(422);
            };
        }
        array_splice($validated,4,1);
        $invoice = Invoice::create($validated);
        $invoice->save();

        foreach ($products as $key => $value) { // This should be done with a validator but this project is mainly for Vue not Laravel.
            $invoice->addProduct($value->productid,$value->amount);
        }
        return $invoice->load('products');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate($this->validations);
        $invoice->update($validated);
        $invoice->save();
        return $invoice;
    }

    public function email(Request $request, Invoice $invoice)
    {
        $email = $request->validate(['email' => 'required|email'])['email'];
        $mail = Mail::to($email)->send(new InvoiceMail($invoice));
        return ['success' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return ['success' => true];
    }
}
