<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorPurchasingOrganization;

class VendorPurchasingOrganizationExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorPurchasingOrganization::select(
                    'vendors.code',
                    'vendor_purchasing_organization.purchasing_organization',
                    'vendor_purchasing_organization.order_currency',
                    'vendor_purchasing_organization.term_of_payment_key',
                )
                ->join('vendors', 'vendors.id', 'vendor_purchasing_organization.vendor_id')
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
            'Order Currency',
            'Term of Payment Key'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Purchasing Organization';
    }
}