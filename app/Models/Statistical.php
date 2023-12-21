<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    public $timestamps = false;
    protected $fillable = [
       'statistical_date', 'statistical_sales', 'statistical_profit', 'statistical_quantity', 'statistical_total_order'
       ];
    protected $primaryKey = 'statistical_id';
    protected $table = 'tbl_statistical';
}
