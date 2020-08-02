<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Email\vendorNotifEmailGr;

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
    protected $description = 'Get PO GR S';

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
        $wsdl = public_path() . "/xml/zbn_eproc_pogr_v3.xml";

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
            $purchaseOrder = \App\Models\PurchaseOrder::get();
            // $purchaseOrder = [
            //     0 => '3010002759',
            //     // 1 => '3010002759'
            // ];
            $poHeader = [];
            $poDetail = []; 

            foreach( $purchaseOrder as $key => $row ) {
                echo "..... \n";
                echo "get po gr \n";
                // $params[0]['EBELN'] = $row;
                $params[0]['EBELN'] = $row->PO_NUMBER;
                $result = $client->__soapCall("ZFM_WS_POGR", $params, NULL, $header);
                // usort($result, function($a, $b) {
                //     return strtotime($a['BUDAT']) < strtotime($b['BUDAT'])?1:-1;
                // });
                // dd(($result->ITAB));

                foreach( $result->ITAB as $value ) {
                    // dd(count($value));
                    if(\is_countable($value) ) {
                        for ($i = 0; $i < count($value); $i++) {
                            $poHeader = \App\Models\PurchaseOrder::where('PO_NUMBER', $value[$i]->EBELN)->first();
                            $checkExistData = \App\Models\PurchaseOrderGr::where('debet_credit',$value[$i]->SHKZG)
                                            ->where('doc_gr',$value[$i]->MBLNR)
                                            ->where('po_item',$value[$i]->EBELP)
                                            ->first();
                            
                            if( $value[$i]->SHKZG != 'H' ) {
                                if( $checkExistData == null ) {
                                    $poDetail = \App\Models\PurchaseOrdersDetail::where('purchase_order_id', $poHeader->id)
                                            ->where('PO_ITEM', $value[$i]->EBELP)
                                            ->first();
                                    // dd($checkExistData);
                                            
                                    if($poDetail->item_category == \App\Models\PurchaseOrdersDetail::SERVICE 
                                        OR $poDetail->item_category == \App\Models\PurchaseOrdersDetail::MaterialText) {
                                        $qty = $value[$i]->ERFMG;
                                    } else {
                                        $qty = $value[$i]->MENGE;
                                    }
    
                                    $poDetail->qty_outstanding  = $poDetail->qty - $qty;
                                    $poDetail->qty_gr           += $qty;
                                    $poDetail->is_gr            = \App\Models\PurchaseOrdersDetail::YesGr;
                                    $poDetail->update();

                                    $amount = $value[$i]->WRBTR;
                                    if( $value[$i]->WAERS == 'IDR' ) {
                                        $amount = ($value[$i]->WRBTR * 100);
                                    }

                                    $insertGr = \App\Models\PurchaseOrderGr::create([
                                        'po_no'                     => $value[$i]->EBELN,
                                        'po_item'                   => $value[$i]->EBELP,
                                        'vendor_id'                 => $poHeader->vendor_id ?? '3000046',
                                        'movement_type'             => $value[$i]->EBELP,
                                        'debet_credit'              => $value[$i]->SHKZG ?? '',//s itu debit h itu kredit
                                        'material_no'               => str_replace('00000000000','',$value[$i]->MATNR),
                                        'qty'                       => $qty,
                                        'amount'                    => $amount,
                                        'plant'                     => $value[$i]->WERKS,
                                        'storage_location'          => $value[$i]->LGORT,
                                        'batch'                     => $value[$i]->CHARG ?? '',
                                        'satuan'                    => $poDetail->unit,//$value[$i]->MEINS ?? $value->ERFME,
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
                                        'price_per_pc'              => ($value[$i]->WRBTR/$qty) * 100,
                                        'cost_center_code'          => $value[$i]->KOSTL, 
                                        'posting_date'              => $value[$i]->BUDAT, 
                                        'item_category'             => $poDetail->item_category,
                                        'description'               => $poDetail->description,
                                    ]);
                                }
                            } 
                        }
                    } else {
                        $poHeader = \App\Models\PurchaseOrder::where('PO_NUMBER', $value->EBELN)->first();
                        $checkExistData = \App\Models\PurchaseOrderGr::where('debet_credit',$value->SHKZG)
                            ->where('doc_gr',$value->MBLNR)
                            ->where('po_item',$value->EBELP)
                            ->first();
                        if( $value->SHKZG != 'H' ) {
                            if( $checkExistData == null ) {
                                $poDetail = \App\Models\PurchaseOrdersDetail::where('purchase_order_id', $poHeader->id)
                                            ->where('PO_ITEM', $value->EBELP)
                                            ->first();
                                if($poDetail->item_category == \App\Models\PurchaseOrdersDetail::SERVICE 
                                    OR $poDetail->item_category == \App\Models\PurchaseOrdersDetail::MaterialText){
                                    $qty = $value->ERFMG;
                                } else {
                                    $qty = $value->MENGE;
                                }

                                $poDetail->qty_outstanding  = $poDetail->qty - $qty;
                                $poDetail->qty_gr           += $qty;
                                $poDetail->is_gr            = \App\Models\PurchaseOrdersDetail::YesGr;
                                $poDetail->update();

                                $amount = $value->WRBTR;
                                if( $value->WAERS == 'IDR' ) {
                                    $amount = ($value->WRBTR * 100);//jika IDR dikali 100
                                }

                                $insertGr = \App\Models\PurchaseOrderGr::create([
                                    'po_no'                     => $value->EBELN,
                                    'po_item'                   => $value->EBELP,
                                    'vendor_id'                 => $poHeader->vendor_id ?? '3000046',
                                    'movement_type'             => $value->EBELP,
                                    'debet_credit'              => $value->SHKZG ?? '',//s itu debit h itu kredit
                                    'material_no'               => str_replace('00000000000','',$value->MATNR),
                                    'qty'                       => $qty,
                                    'amount'                    => $amount,
                                    'plant'                     => $value->WERKS,
                                    'storage_location'          => $value->LGORT,
                                    'batch'                     => $value->CHARG ?? '',
                                    'satuan'                    => $poDetail->unit,//$value->MEINS ?? $value->ERFME,
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
                                    'price_per_pc'              => ($value->WRBTR/$qty) * 100,
                                    'cost_center_code'          => $value->KOSTL, 
                                    'posting_date'              => $value->BUDAT, 
                                    'item_category'             => $poDetail->item_category,
                                    'description'               => $poDetail->description,
                                ]);
                            }
                        }
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
