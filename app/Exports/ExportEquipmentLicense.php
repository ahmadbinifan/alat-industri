<?php

namespace App\Exports;

use App\Models\Equipment_license;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportEquipmentLicense implements FromCollection, WithHeadings
{

    // protected $id_section;

    public function __construct()
    {
    }

    public function collection()
    {
        if (session('id_section') == 'LEG' || session('id_section') == 'HRD' || session('id_section') == 'HSE') {
            return Equipment_license::query()
                ->select(
                    'equipment_license.doc_no',
                    'equipment_license.company',
                    'equipment_license.filing_date',
                    'equipment_license.tag_number',
                    'equipment_license.owner_asset',
                    'equipment_license.location_asset',
                    'equipment_license.last_inspection',
                    'equipment_license.estimated_cost',
                    'equipment_license.status',
                    'equipment_license.id_section',
                )
                ->join('detail_equipment_license', 'detail_equipment_license.doc_no', '=', 'equipment_license.doc_no')
                ->orderBy('equipment_license.updated_at', 'desc')
                ->get();
        } else {
            return Equipment_license::query()
                ->select('eq.doc_no
                ,eq.company
                ,eq.filing_date
                ,eq.tag_number
                ,eq.owner_asset
                ,eq.location_asset
                ,eq.last_inspection
                ,eq.estimated_cost
                ,eq.status
                ,eq.id_section
                ')
                ->where('eq.id_section', session('id_section'))
                ->join('detail', 'detail.doc_no', '=', 'eq.doc_no')
                ->orderBy('eq.updated_at', 'desc')
                ->get();
        }
    }
    public function headings(): array
    {
        return [
            "doc_no",
            "company",
            "filling_date",
            "tag_number",
            "owner_asset",
            "location_asset",
            "last_inspection",
            "estimated_cost",
            "status",
            "section",
        ];
    }
}
