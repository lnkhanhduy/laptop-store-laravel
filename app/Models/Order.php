<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'order_code',
        'order_name',
        'order_address',
        'order_phone',
        'order_note',
        'order_payment_method',
        'voucher_id',
        'order_total',
        'order_status'
    ];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';

    public function getOrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id')->with('getProduct');
    }

    public function getProduct()
    {
        return $this->hasManyThrough(Product::class, OrderDetail::class, 'order_id', 'product_id', 'order_id', 'product_id');
    }
}