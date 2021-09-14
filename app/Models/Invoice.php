<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $fillable = ['billToName','billToAddr1','billToAddr2','dueDate'];
    use HasFactory;

    public function products()
    {
        return $this->hasMany(InvoiceProducts::class);
    }

    public function addProduct($id,$amount)
    {
        $item = InvoiceProducts::create([
            'invoice_id' => $this->id,
            'product_id' => $id,
            'amount' => $amount
        ]);
        $item->save();
        return $item;
    }

}
