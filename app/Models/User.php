<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'user_name', 'email', 'phone', 'password', 'role', 'status'
    ];

    public function lender()
    {
        return $this->hasOne(Lender::class, 'user_id');
    }
}