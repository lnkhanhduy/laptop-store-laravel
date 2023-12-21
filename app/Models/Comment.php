<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;
    protected $fillable = [
     'comment_content','comment_reply','user_id' ,'product_id'
    ];
    protected $primaryKey = 'comment_id';
    protected $table = 'tbl_comment';

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
