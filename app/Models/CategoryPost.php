<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    public $timestamps = false;
    protected $fillable = [
     'category_post_name','category_post_slug' ,'category_post_status'
    ];
    protected $primaryKey = 'category_post_id';
    protected $table = 'tbl_category_post';
}
