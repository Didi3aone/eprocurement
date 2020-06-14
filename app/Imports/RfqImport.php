<?php

namespace App\Imports;

use App\Models\Rfq;
use Maatwebsite\Excel\Concerns\ToModel;

class RfqImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rfq([
            'purchasing_document' => $row[0],
            'company_code' => $row[1],
            'purchasing_doc_category' => $row[2],
            'purchasing_doc_type' => $row[3],
            'deletion_indicator' => $row[4],
            'vendor' => $row[8],
            'language_key' => 'EN',
            'payment_terms' => $row[9],
            'payment_in1' => $row[10],
            'payment_in2' => $row[11],
            'payment_in3' => $row[12],
            'disc_percent1' => $row[13],
            'disc_percent2' => $row[14],
            'purchasing_org' => $row[15],
            'purchasing_group' => $row[16],
            'currency' => $row[17],
            'exchange_rate' => $row[18],
            'exchange_rate_fixed' => $row[19],
            'document_date' => $row[20],
            'quotation_deadline' => $row[21],
            'created_by' => $row[6],
            'last_changed' => $row[7],
        ]);
    }
}
