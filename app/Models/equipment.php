<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipment extends Model
{
    use HasFactory;
    protected $table = 'tb_equipment';

    public function equipmentLicenses()
    {
        return $this->hasMany(Equipment_license::class, 'tag_number', 'tag_number'); // pastikan foreign key sesuai
    }
}
