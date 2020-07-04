<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorCompanyData;

class VendorCompanyDataExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorCompanyData::select(
                    'vendors.code',
                    'vendor_company_data.company_code',
                    'vendor_company_data.account_gl',
                    'vendor_company_data.planning_group',
                    'vendor_company_data.payment_terms'
                )
                ->join('vendors', 'vendors.id', 'vendor_company_data.vendor_id')
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
            'Company Code',
            'Account GL',
            'Planning Group',
            'Payment Terms'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Company Data';
    }
}