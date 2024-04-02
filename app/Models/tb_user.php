<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class tb_user extends Authenticatable
{
    use HasFactory;
    protected $table = 'tb_user';
    protected $fillable = [
        'id_user',
        'fullname',
        'username',
        'email',
        'password',
    ];
}
