<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_equipment extends Model
{
    use HasFactory;
    protected $table = 'detail_equipment_license';
    protected $fillable = [
        'doc_no',
        'license_no',
        'license_from',
        'issued_date_document',
        'last_license_date',
        'reminder_checking_date',
        'reminder_testing_date',
        'frequency_check',
        're_license',
        'frequency_testing',
        're_license_testing',
    ];
    public function equipment()
    {
        return $this->belongsTo(Equipment_license::class, 'doc_no', 'doc_no');
    }
}
