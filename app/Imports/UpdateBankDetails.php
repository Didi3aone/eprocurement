<?php

namespace App\Imports;

use App\Models\MasterUnit;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UpdateBankDetails implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row ) {

            $vendor = \App\Models\Vendor::where('code', $row[0])->first();

            \App\Models\Vendor\VendorBankDetails::where('vendor_id', $vendor->id)
                ->update([
                    'partner_bank' => $row[1]
                ]);
        }
    }
}