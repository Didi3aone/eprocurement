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

        $auth = Self::Authentication($username, $password);
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);
        $params = [];
        try {
            $getPO = [
                0 => '3010000001'
            ];

            foreach( $getPO as $rows ) {
                $params[0]['EBELN'] = $rows;
            }

            $result = $client->__soapCall("ZFM_WS_POGR", $params, NULL, $header);
            dd($result);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
