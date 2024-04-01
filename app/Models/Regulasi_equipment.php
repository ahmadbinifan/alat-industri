<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulasi_equipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'regulation_no',
        'regulation_desc',
        'category',
        'document_k3',
        'check_frequency',
    ];
}
