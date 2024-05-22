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
                    'detail_equipment_license.license_no',
                    'detail_equipment_license.license_from',
                    'detail_equipment_license.issued_date_document',
                    'detail_equipment_license.last_license_date',
                    'detail_equipment_license.reminder_checking_date',
                    'detail_equipment_license.reminder_testing_date',
                    'detail_equipment_license.frequency_check',
                    'detail_equipment_license.re_license',
                    'detail_equipment_license.frequency_testing',
                    'detail_equipment_license.re_license_testing',
                    'detail_equipment_license.reminderSchedule',
                )
                ->join('detail_equipment_license', 'detail_equipment_license.doc_no', '=', 'equipment_license.doc_no')
                ->orderBy('equipment_license.updated_at', 'desc')
                ->get();
        } else {
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
                    'detail_equipment_license.license_no',
                    'detail_equipment_license.license_from',
                    'detail_equipment_license.issued_date_document',
                    'detail_equipment_license.last_license_date',
                    'detail_equipment_license.reminder_checking_date',
                    'detail_equipment_license.reminder_testing_date',
                    'detail_equipment_license.frequency_check',
                    'detail_equipment_license.re_license',
                    'detail_equipment_license.frequency_testing',
                    'detail_equipment_license.re_license_testing',
                    'detail_equipment_license.reminderSchedule',
                )
                ->where('equipment_license.id_section', session('id_section'))
                ->join('detail_equipment_license', 'detail_equipment_license.doc_no', '=', 'equipment_license.doc_no')
                ->orderBy('equipment_license.updated_at', 'desc')
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
            "license_no",
            "license_from",
            "issued_date_document",
            "last_license_date",
            "reminder_checking_date",
            "reminder_testing_date",
            "frequency_check",
            "re_license",
            "frequency_testing",
            "re_license_testing",
            "reminderSchedule",
        ];
    }
}
