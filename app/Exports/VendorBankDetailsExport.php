<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorBankDetails;

class VendorBankDetailsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        $data = VendorBankDetails::select(
                    'vendors.code',
                    'vendor_bank_details.bank_country_key',
                    'vendor_bank_details.bank_keys',
                    'vendor_bank_details.account_no',
                    'vendor_bank_details.iban',
                    'vendor_bank_details.bank_details',
                    'vendor_bank_details.account_holder_name'
                )
                ->join('vendors', 'vendors.id', 'vendor_bank_details.vendor_id')
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
            'Bank Country Key',
            'Bank Keys',
            'Account No',
            'IBAN',
            'Bank Details',
            'Account Holder Name'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Bank Details';
    }
}