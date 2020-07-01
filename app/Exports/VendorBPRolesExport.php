<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorBPRoles;

class VendorBPRolesExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorBPROles::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'BP Roles';
    }
}