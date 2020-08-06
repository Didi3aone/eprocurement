<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\UserVendors;

class VendorGeneralDataExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return Builder
     */
    public function collection()
    {
        $data = UserVendors::select(
                    'vendors.code',
                    'master_vendor_title.name AS master_vendor_title_name',
                    'master_vendor_bp_group.code AS master_vendor_bp_group_code',
                    'master_vendor_bp_group.name AS master_vendor_bp_group_name',
                    'vendors.company_name', 
                    'vendors.different_city',
                    'vendors.city',
                    'vendors.postal_code',
                    'vendors.country',
                    'vendors.street',
                    'vendors.street_2',
                    'vendors.street_3',
                    'vendors.street_4',
                    'vendors.street_5',
                    'vendors.language',
                    'vendors.office_telephone',
                    'vendors.telephone_2',
                    'vendors.telephone_3',
                    'vendors.office_fax',
                    'vendors.fax_2',
                    'vendors.name',
                    'vendors.email',
                    'vendors.email_2',
                    'vendors.payment_terms',
                    \DB::raw("
                        CASE
                            WHEN vendors.status = 1 THEN 'Approved'
                            WHEN vendors.status = 2 THEN 'Rejected'
                            ELSE 'Waiting Approval'
                        END AS status
                    ")
                )
                ->join('master_vendor_title', 'master_vendor_title.id', 'vendors.vendor_title_id')
                ->join('master_vendor_bp_group', 'master_vendor_bp_group.id', 'vendors.vendor_bp_group_id')
                ->where('vendors.is_export', 0)
                ->get();
        return $data;
        // return UserVendors::get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Vendor Code',
            'Vendor Title',
            'BP Group',
            'Account Group',
            'Company Name', 
            'Different City',
            'City',
            'Postal Code',
            'Country',
            'Street',
            'Street 2',
            'Street 3',
            'Street 4',
            'Street 5',
            'Language',
            'Default Telephone',
            'Additional Telephone 2',
            'Additional Telephone 3',
            'Default Fax',
            'Additional Fax 2',
            'Name',
            'Default Email',
            'Additional Email 2',
            'Payment Terms',
            'Status'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'General Data';
    }
}