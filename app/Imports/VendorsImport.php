<?php

namespace App\Imports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;

class VendorsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Vendor([
            'code' => $row[0],
            'name' => $row[2],
            'email' => '',
            'npwp' => '',
            'company_type' => 1,
            'company_from' => 1,
            'country' => $row[1],
            'name1' => $row[2],
            'name2' => $row[3],
            'name3' => $row[4],
            'name4' => $row[5],
            'city' => $row[6],
            'district' => $row[7],
            'region' => $row[11],
            'search_term' => $row[12],
            'street' => $row[13],
            'address' => $row[14],
            'first_name' => $row[131],
            'title' => $row[18],
            'house_number' => $row[133],
            'postal_code' => $row[10],
            'country_key' => $row[141],
            'train_station' => $row[19],
            'int_location_no1' => $row[20],
            'int_location_no2' => $row[21],
            'check_digit' => $row[24],
            'created_on' => $row[28],
            'created_by' => $row[29],
            'account_group' => $row[32],
            'language_key' => $row[38],
            'tax_number1' => $row[39],
            'tax_number2' => $row[40],
            'telephone1' => $row[44],
            'telephone2' => $row[45],
            'fax_number' => $row[46],
            'trading_partner' => $row[51],
            'fiscal_address' => $row[52],
            'vendor_sub_range_relevant' => $row[65],
            'plant_level_relevant' => $row[66],
            'status_data_transfer' => $row[68],
            'transportation_zone' => $row[73],
            'tax_base' => $row[84],
            'confirmation_time' => $row[94],
            'ric_number' => $row[109],
            'legal_nature' => $row[113],
            'capital_amount' => $row[121],
            'cae_code' => $row[173],
            'staging_time' => $row[176]
        ]);
    }
}
