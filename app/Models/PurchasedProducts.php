<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Product;

class PurchasedProducts extends Model
{
    use HasFactory;    
    protected $fillable = [
        'product_id', 
        'invoice_id', 
        'number_of_items', 
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
    
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'id', 'invoice_id');
    }

}
