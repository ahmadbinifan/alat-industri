<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Regulasi_equipment;
use App\Models\equipment;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment_license extends Model
{
    use HasFactory;
    protected $table = 'equipment_license';
    protected $fillable = [
        'doc_no', 'company', 'filing_date', 'tag_number', 'owner_asset', 'location_asset',
        'document_requirements', 'idRegulasi', 'last_inspection', 'estimated_cost', 'status', 'id_section',
        'status', 'attachFromHSE', 'old_doc', 'new_doc_no', 'old_doc_no'
    ];
    public function regulasi(): HasOne
    {
        return $this->hasOne(Regulasi_equipment::class);
    }
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'tag_number', 'tag_number'); // pastikan foreign key sesuai
    }
    public function scopeSearch($query, $value)
    {
        $query->where('doc_no', 'like', "%{$value}%")
            ->orWhere('company', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('tag_number', 'like', "%{$value}%");
    }
}
