<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VendorExport implements WithMultipleSheets
{
    use Exportable;
    
    /**
     * @return array
     */
    public function sheets(): array
    {
        ini_set('memory_limit', '-1');
        $sheets = [];

        $sheet = [
            'General Data' => new VendorGeneralDataExport(),
            'BP Roles' => new VendorBPRolesExport(),
            'Company Data' => new VendorCompanyDataExport(),
            'Withholding Tax Data' => new VendorWithholdingTaxTypeExport(),
            'Purchasing Organization' => new VendorPurchasingOrganizationExport(),
            'Partner Functions' => new VendorPartnerFunctionsExport(),
            'Bank Details' => new VendorBankDetailsExport(),
            'Tax Numbers' => new VendorTaxNumbersExport(),
            'Identification Numbers' => new VendorIdentificationNumbersExport(),
        ];
        
        foreach ($sheet as $key => $row) {
            $sheets[] = $row;
        }

        return $sheets;
    }
}