<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchasedProducts;

class Invoice extends Model
{
    use HasFactory;    
    protected $fillable = [
        'total', 
        'paid'
    ];

    public function items(){
        return $this->hasMany(PurchasedProducts::class);
    }
}
