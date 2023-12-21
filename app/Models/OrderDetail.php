<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
     'order_id','product_id', 'product_quantity', 'product_price'
    ];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_order_detail';

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
