<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'category_product_name','category_product_slug','category_product_parent','category_product_status'
       ];
    protected $primaryKey = 'category_product_id';
    protected $table = 'tbl_category_product';

    public function getNameCategory()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_product_parent', 'category_product_id');
    }
}
