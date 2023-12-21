<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable = [
     'post_title','post_slug','post_desc' ,'post_content','post_image','category_post_id','post_views','post_status'
    ];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_post';

    public function getCategoryName()
    {
        return $this->belongsTo(CategoryPost::class, 'category_post_id', 'category_post_id');
    }
}
