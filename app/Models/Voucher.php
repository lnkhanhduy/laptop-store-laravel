<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'voucher_name',
        'voucher_code',
        'voucher_type',
        'voucher_discount_amount',
        'voucher_quantity',
        'voucher_used',
        'voucher_used_by_user',
        'voucher_status',
    ];
    protected $primaryKey = 'voucher_id';
    protected $table = 'tbl_voucher';
}
