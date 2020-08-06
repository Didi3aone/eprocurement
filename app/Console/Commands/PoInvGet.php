<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PoInvGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'po:inv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get PO Invoice';

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
        $wsdl = public_path() . "/xml/zbn_eproc_histinv.xml";

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
            //     0 => '3010002118',
            //     1 => '3010000001'
            // ];
            $poHeader = [];
            $poDetail = [];

            foreach( $purchaseOrder as $key => $row ) {
                echo "..... \n";
                echo "get po gr \n";
                $params[0]['EBELN'] = $row->PO_NUMBER;
                $result = $client->__soapCall("ZFM_WS_HISTINV", $params, NULL, $header);
                dd($result->ITAB);
                foreach( $result->ITAB as $value ) {
                    if(\is_countable($value) ) {
                        // SHKZG
                        $billing = \App\Models\Vendor\Billing::where('document_no',$value[$key]->BELNR)->first();
                      
                    } else {
                       
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
