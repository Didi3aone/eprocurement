<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorPartnerFunctions;

class VendorPartnerFunctionsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorPartnerFunctions::select(
                    'vendors.code',
                    'vendor_partner_functions.purchasing_organization',
                    'vendor_partner_functions.partner_functions'
                )
                ->join('vendors', 'vendors.id', 'vendor_partner_functions.vendor_id')
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
            'Purchasing Organization',
            'Partner Functions'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Partner Functions';
    }
}