<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TempPurchaseRequest;
use App\Models\Material;

class PrMrpGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MRP:GET';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data PR MRP from SAP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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
        ini_set('memory_limit', '20000M');
        //ini_set('memory_limit', '-1');
        set_time_limit(0);
        $wsdl = public_path() . "/xml/zbn_eproc_prmrp_prod.xml";

        $username = "IT_02";
        $password = "ademsari";
        $client = new \SoapClient($wsdl, array(
                'login' => 'IT_02',
                'password' => 'ademsari',
                'trace' => true
            )
        );

        $params = [];
        $params[0]['BANFN'] = '';
        $auth = Self::Authentication($username, $password);
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);
        
        $params[0]['BSART'] = 'Z102';
        $params[0]['ITAB']  = [];
        $params[0]['OPEN']  = 'X';
        
        try {
            echo "+++++++++++++++++++++++++++++++++++++++++\n";
            echo ".......... GET DATA PR MRP ..............\n";
            echo ".......... Start proccess  ..............\n";
            echo "+++++++++++++++++++++++++++++++++++++++++\n";
            $result = $client->__soapCall("ZFM_WS_POMRP", $params, NULL, $header);
            $array = (object) $result;
            // dd($result);
            foreach( $result->ITAB as $rows ) {
                $this->output->progressStart(count($rows));
                for ($i = 0; $i <= count($rows); $i++) {
                    sleep(0);
                    $prNo = $rows[$i]->BANFN;
                    $this->output->progressAdvance();
                    $delivDate   = str_replace('/','-',$rows[$i]->LFDAT);
                    $releaseDate = str_replace('/','-',$rows[$i]->FRGDT);

                    $materials = Material::where('code',str_replace('00000000000','',$rows[$i]->MATNR))->first();
                    $tempPurchaseRequest                          = new TempPurchaseRequest;
                    $tempPurchaseRequest->PR_NO                   = $rows[$i]->BANFN;
                    $tempPurchaseRequest->description             = $materials->description ?? $rows[$i]->TXZ01;
                    $tempPurchaseRequest->category                = $rows[$i]->PSTYP;
                    $tempPurchaseRequest->doc_type                = $rows[$i]->BSART;
                    $tempPurchaseRequest->qty                     = $rows[$i]->MENGE;
                    $tempPurchaseRequest->unit                    = $rows[$i]->MEINS;
                    $tempPurchaseRequest->notes                   = 'PR MRP';
                    $tempPurchaseRequest->material_id             = str_replace('00000000000','',$rows[$i]->MATNR);
                    // $tempPurchaseRequest->gl_acct_code            = '';
                    $tempPurchaseRequest->request_no              = $rows[$i]->BEDNR;
                    $tempPurchaseRequest->plant_code              = $rows[$i]->WERKS;
                    $tempPurchaseRequest->purchasing_group_code   = $rows[$i]->EKGRP;
                    $tempPurchaseRequest->preq_name               = $rows[$i]->ERNAM;
                    $tempPurchaseRequest->storage_location        = $rows[$i]->LGORT;
                    $tempPurchaseRequest->material_group          = $rows[$i]->MATKL;
                    // $tempPurchaseRequest->cost_center_code        = '';
                    $tempPurchaseRequest->profit_center_code      = $materials->profit_center_code ?? 00;
                    $tempPurchaseRequest->delivery_date           = \toDateDb($delivDate);
                    $tempPurchaseRequest->release_date            = \toDateDb($releaseDate);
                    $tempPurchaseRequest->account_assignment      = $rows[$i]->KNTTP;
                    $tempPurchaseRequest->text_id                 = 'PR';
                    $tempPurchaseRequest->text_form               = 'EN';
                    $tempPurchaseRequest->text_line               = $rows[$i]->TXZ01;
                    $tempPurchaseRequest->short_text              = $rows[$i]->TXZ01;
                    $tempPurchaseRequest->preq_item               = $rows[$i]->BNFPO;

                    $tempPurchaseRequest->save();
                    echo "PR No ".$prNo." berhasil disimpan didatabase \n";
                }
            }
            $this->output->progressFinish();
        } catch (\Exception $e){
            echo $e;
            // echo "Soap request gagal! Response : ".$client->__getLastResponse();
        }
    }
}
