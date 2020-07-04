<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorTaxNumbers;

class VendorTaxNumbersExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorTaxNumbers::select(
                    'vendors.code',
                    'vendor_tax_numbers.tax_numbers_category',
                    'vendor_tax_numbers.tax_numbers'
                )
                ->join('vendors', 'vendors.id', 'vendor_tax_numbers.vendor_id')
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
            'Tax Numbers Category',
            'Tax Numbers'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Tax Numbers';
    }
}