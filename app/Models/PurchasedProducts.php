<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedProducts extends Model
{
    use HasFactory;    
    protected $fillable = [
        'product_id', 
        'invoice_id', 
        'number_of_items', 
    ];
}
