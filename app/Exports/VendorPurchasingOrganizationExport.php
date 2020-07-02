<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorPurchasingOrganization;

class VendorPurchasingOrganizationExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorPurchasingOrganization::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Purchasing Organization';
    }
}