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
        echo "Start ..... \n";
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
                0 => '3010002118',
                1 => '3010000001'
            ];
            $poHeader = [];
            $poDetail = [];

            foreach( $purchaseOrder as $key => $row ) {
                echo "..... \n";
                echo "get po gr \n";
                $params[0]['EBELN'] = $row;
                $result = $client->__soapCall("ZFM_WS_POGR", $params, NULL, $header);
                foreach( $result->ITAB as $value ) {
                    if( is_array($value) ) {
                        for ($i = 0; $i <= count($value); $i++) {
                            if( !empty($value[$i]) ) {
                                $poHeader = \App\Models\PurchaseOrder::where('PO_NUMBER', $value[$i]->EBELN)->first();
    
                                if( !empty($poHeader) ) {
                                    $poDetail = \App\Models\PurchaseOrdersDetail::where('purchsase_order_id', $poHeader->id)
                                                ->where('PO_ITEM', $value[$i]->EBELP)
                                                ->first();
                                    
                                    $poDetail->qty_gr           = $value[$i]->MENGE;
                                    $poDetail->qty_outstanding  = $poDetail->qty - $value[$i]->MENGE;
                                    $poDetail->update();
                                }
        
            
                                $insertGr = \App\Models\PurchaseOrderGr::create([
                                    'po_no'                     => $value[$i]->EBELN,
                                    'po_item'                   => $value[$i]->EBELP,
                                    'vendor_id'                 => $poHeader->vendor_id ?? '3000046',
                                    'movement_type'             => $value[$i]->EBELP,
                                    'debet_credit'              => $value[$i]->SHKZG ?? '',//s itu debit h itu kredit
                                    'material_no'               => str_replace('00000000000','',$value[$i]->MATNR),
                                    'qty'                       => $value[$i]->MENGE,
                                    'amount'                    => $value[$i]->DMBTR,
                                    'plant'                     => $value[$i]->WERKS,
                                    'storage_location'          => $value[$i]->LGORT,
                                    'batch'                     => $value[$i]->CHARG ?? '',
                                    'satuan'                    => $value[$i]->MEINS,
                                    'currency'                  => $value[$i]->WAERS,
                                    'doc_gr'                    => $value[$i]->MBLNR,
                                    'tahun_gr'                  => $value[$i]->MJAHR,
                                    'item_gr'                   => $value[$i]->ZEILE,
                                    'reference_document'        => $value[$i]->LFBNR,
                                    'reference_document_item'   => $value[$i]->LFPOS,
                                    'material_document'         => $value[$i]->SMBLN ?? '',
                                    'material_doc_item'         => $value[$i]->SMBLP,
                                    'delivery_completed'        => $value[$i]->ELIKZ,
                                    'gl_account'                => $value[$i]->SAKTO ?? '',
                                    'profit_center'             => $value[$i]->PRCTR ?? '',
                                    'purchase_order_detail_id'  => $poDetail->id ?? 0,
                                    'price_per_pc'              => ($value[$i]->DMBTR/$value[$i]->MENGE) * 100
                                ]);
                            }
                        }
                    } else {
                        $poHeader = \App\Models\PurchaseOrder::where('PO_NUMBER', $value->EBELN)->first();
                        if( !empty($poHeader) ) {
                            $poDetail = \App\Models\PurchaseOrdersDetail::where('purchsase_order_id', $poHeader->id)
                                        ->where('PO_ITEM',$value->EBELP)
                                        ->first();
                            
                            $poDetail->qty_gr =  $value->MENGE;
                            $poDetail->qty_outstanding = $poDetail->qty - $value->MENGE;
                            $poDetail->update();
                        }

    
                        $insertGr = \App\Models\PurchaseOrderGr::create([
                            'po_no'                     => $value->EBELN,
                            'po_item'                   => $value->EBELP,
                            'vendor_id'                 => $poHeader->vendor_id ?? '3000046',
                            'movement_type'             => $value->EBELP,
                            'debet_credit'              => $value->SHKZG ?? '',//s itu debit h itu kredit
                            'material_no'               => str_replace('00000000000','',$value->MATNR),
                            'qty'                       => $value->MENGE,
                            'amount'                    => $value->DMBTR,
                            'plant'                     => $value->WERKS,
                            'storage_location'          => $value->LGORT,
                            'batch'                     => $value->CHARG ?? '',
                            'satuan'                    => $value->MEINS,
                            'currency'                  => $value->WAERS,
                            'doc_gr'                    => $value->MBLNR,
                            'tahun_gr'                  => $value->MJAHR,
                            'item_gr'                   => $value->ZEILE,
                            'reference_document'        => $value->LFBNR,
                            'reference_document_item'   => $value->LFPOS,
                            'material_document'         => $value->SMBLN ?? '',
                            'material_doc_item'         => $value->SMBLP,
                            'delivery_completed'        => $value->ELIKZ,
                            'gl_account'                => $value->SAKTO ?? '',
                            'profit_center'             => $value->PRCTR ?? '',
                            'purchase_order_detail_id'  => $poDetail->id ?? 0,
                            'price_per_pc'              => ($value->DMBTR/$value->MENGE) * 100
                        ]);
                    }
                }
            }
            echo "Done prosess ".date('Y-m-d H:i:s')."\n";
        } catch (\Throwable $th) {
            throw $th;
            echo "Soap request gagal! Response : ".$client->__getLastResponse();
        }
    }
}
