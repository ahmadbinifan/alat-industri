<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Regulasi_equipment;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment_license extends Model
{
    use HasFactory;
    protected $table = 'equipment_license';
    protected $fillable = [
        'doc_no', 'company', 'filing_date', 'tag_number', 'owner_asset', 'location_asset',
        'document_requirements', 'idRegulasi', 'last_inspection', 'estimated_cost', 'status', 'id_section',
        'status', 'attachFromHSE'
    ];
    public function regulasi(): HasOne
    {
        return $this->hasOne(Regulasi_equipment::class);
    }
    // public function idRegulasi()
    // {
    //     return $this->belongsTo(Regulasi_equipment::class, 'id');
    // }
    public function scopeSearch($query, $value)
    {
        $query->where('doc_no', 'like', "%{$value}%")
            ->orWhere('company', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('tag_number', 'like', "%{$value}%");
    }
}
