<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PoGrGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'po:gr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get PO GR';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

     /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function Authentication ($user, $pass)
    {
        $this->Username = $user;
        $this->Password = $pass;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $wsdl = public_path() . "/xml/zbn_eproc_pogr.xml";

        $username = "IT_02";
        $password = "ademsari";
        $client = new \SoapClient($wsdl, array(
                'login' => 'IT_02',
                'password' => 'ademsari',
                'trace' => true
            )
        );

        $auth = ['username' => $username, 'password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);
        $params = [];
        try {
            $purchaseOrder = \App\Models\PurchaseOrder::limit(1)->get();
            $purchaseOrder = [
                0 => '3010000001',
                1 => '3010002118'
            ];

            foreach( $purchaseOrder as $key => $rows ) {
                $params[0]['EBELN'] = $rows;
                $result = $client->__soapCall("ZFM_WS_POGR", $params, NULL, $header);
                foreach( $result->ITAB as $value ) {
                    for ($i = 0; $i <= count($row); $i++) {
                        $poHeader =  \App\Models\PurchaseOrder::where('PO_NUMBER', $row[$i]->EBELN)->first();
    
                        $insertGr = \App\Models\PurchaseOrderGr::create([
                            'po_no' => $row[$i]->EBELN,
                            'po_item' => $row[$i]->EBELP,
                            'vendor_id' => $poHeader->vendor_id,
                            'movement_type' => $row[$i]->EBELP,
                            'debet_credit' => '',
                            'material_no' => str_replace('00000000000','',$row[$i]->MATNR),
                            'qty' => $row[$i]->MENGE,
                            'amount' => $row[$i]->DMBTR,
                            'plant' => $row[$i]->WERKS,
                            'storage_location' => $row[$i]->LGORT,
                            'batch' => '',
                            'satuan' => $row[$i]->MEINS,
                            'currency' => $row[$i]->WAERS,
                            'doc_gr' => $row[$i]->MBLNR,
                            'tahun_gr' => $row[$i]->MJAHR,
                            'item_gr' => $row[$i]->ZEILE,
                            'reference_document' => $row[$i]->LFBNR,
                            'reference_document_item' => $row[$i]->LFPOS,
                            'material_document' => '',
                            'material_doc_item' => $row[$i]->SMBLP,
                            'delivery_completed' => $row[$i]->ELIKZ,
                            'gl_account' => '',
                            'profit_center' => '',
                            'purchase_order_detail_id' =>''
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
            echo "Soap request gagal! Response : ".$client->__getLastResponse();
        }
    }
}
