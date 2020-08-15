<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorWithholdingTaxType;

class VendorWithholdingTaxTypeExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorWithholdingTaxType::select(
                    'vendors.code',
                    'vendor_withholding_tax_type.company_code',
                    'vendor_withholding_tax_type.withholding_tax_type',
                    'vendor_withholding_tax_type.subject'
                )
                ->join('vendors', 'vendors.id', 'vendor_withholding_tax_type.vendor_id')
                ->where('vendors.is_export', 0)
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
            'Withholding Tax Type',
            'Subject'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Withholding Tax Data';
    }
}