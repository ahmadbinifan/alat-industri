<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approval_equipment_license extends Model
{
    use HasFactory;
    protected $table = "approval_equipment_license";
    protected $fillable = [
        'doc_no', 'fullname', 'id_section', 'note', 'approved_at'
    ];
}
