<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id','user_id','quantity'
       ];
    protected $primaryKey = 'cart_id';
    protected $table = 'tbl_cart';

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
