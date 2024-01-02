<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class admin extends  Authenticatable
{
    use HasApiTokens, HasFactory;


    protected $table = 'admins';

    protected $fillable = [
        'phone_number',
        'name',
        'password',
        'special_code',
        'email',
    ];
    protected $hidden = [
        'password',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}
