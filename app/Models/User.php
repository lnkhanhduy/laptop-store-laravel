<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;
    protected $fillable = [
     'full_name','user_email' ,'user_password','reset_code',
    ];
    protected $primaryKey = 'user_id';
    protected $table = 'tbl_user';
}
