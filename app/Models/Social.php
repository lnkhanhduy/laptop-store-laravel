<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public $timestamps = false;
    protected $fillable = [
     'provider_user_id','provider' ,'user_id'
    ];
    protected $primaryKey = 'social_id';
    protected $table = 'tbl_social';

    public function login()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
