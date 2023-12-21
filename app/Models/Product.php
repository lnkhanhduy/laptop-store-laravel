<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_name','product_slug','category_product_id' ,'brand_id','product_quantity','product_sold','product_desc','product_content','product_cost','product_price','product_price_discount','product_image','product_status','product_views'
       ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function getBrandName()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function getCategoryName()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_product_id', 'category_product_id');
    }


}
