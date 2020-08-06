<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorIdentificationNumbers;

class VendorIdentificationNumbersExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorIdentificationNumbers::select(
                    'vendors.code',
                    'vendor_identification_numbers.identification_type',
                    'vendor_identification_numbers.identification_numbers'
                )
                ->join('vendors', 'vendors.id', 'vendor_identification_numbers.vendor_id')
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
            'Identification Type',
            'Identification Numbers'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Identification Numbers';
    }
}