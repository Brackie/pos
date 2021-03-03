<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchasedProducts;

class Product extends Model
{
    use HasFactory;    
    protected $fillable = [
        'product_code', 
        'product_name', 
        'product_stock', 
        'product_price'
    ];

    public function items(){
        return $this->hasMany(PurchasedProducts::class);
    }
}
