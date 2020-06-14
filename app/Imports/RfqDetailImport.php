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
            'item' => $row[1],
            'document_item' => $row[2],
            'deletion_indicator' => $row[3],
            'status' => $row[4],
            'last_changed_on' => $row[5],
            'short_text' => $row[6],
            'material' => $row[7],
            'company_code' => $row[9],
            'plant' => $row[10],
            'storage_location' => $row[11],
            'req_tracking_number' => $row[12],
            'material_group' => $row[13],
            'supplier_material_number' => $row[14],
            'target_quantity' => $row[15],
            'order_unit' => $row[16],
            'order_price_unit' => $row[17],
            'quantity_conversion' => $row[18],
            'equal_to' => $row[20],
            'denominal' => $row[21],
            'net_order_price' => $row[22],
            'price_unit' => $row[23],
            'gross_order_value' => $row[24],
            'quotation_deadline' => $row[25],
            'gr_processing_time' => $row[26],
            'tax_code' => $row[27],
            'base_unit_of_measures' => $row[30],
            'oa_target_value' => $row[31],
            'price_date' => $row[32],
            'purchasing_doc_category' => $row[33],
            'net_weight' => $row[37],
            'unit_of_weight' => $row[38],
            'profit_center' => $row[39],
            'gross_weight' => $row[40],
            'package_number' => $row[41],
            'mat_ledger_active' => $row[42],
            'purchase_requisition' => $row[43],
            'item_of_requisition' => $row[44],
            'material_type' => $row[45],
            'rebate_basis' => $row[46],
            'requisitioner' => $row[47],
        ]);
    }
}
