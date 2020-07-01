<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorBankDetails;

class VendorBankDetailsExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorBankDetails::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Bank Details';
    }
}