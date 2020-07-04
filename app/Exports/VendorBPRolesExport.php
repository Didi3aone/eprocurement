<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorBPRoles;

class VendorBPRolesExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorBPROles::select(
                    'vendors.code',
                    'vendor_bp_roles.bp_role'
                )
                ->join('vendors', 'vendors.id', 'vendor_bp_roles.vendor_id')
                ->get();
        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Vendor Code',
            'BP Roles'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'BP Roles';
    }
}