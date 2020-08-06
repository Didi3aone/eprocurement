<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PoGrDetailGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'po:gr-detail';

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
        ini_set('memory_limit', '20000M');
        //ini_set('memory_limit', '-1');
        set_time_limit(0);
   
        
        echo "----------CLONE DATA PR MRP -----------\n";
        echo "+++++++++++++++++++++++++++++++++++++++\n";
        echo "..........Start proccess.................\n";
        $getPOgr = \App\Models\PurchaseOrderGr::all();

        foreach( $getPOgr as $key => $value ) {
            
        }
    }
}