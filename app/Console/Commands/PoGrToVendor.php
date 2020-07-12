<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PoGrToVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gr:vendor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to vendor';

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
    public function handle()
    {
        $getPoGR = \App\Models\PurchaseOrderGr::select(
                    'po_no',
                    'vendor_id'
                )
                ->join('purchase_orders','purchase_orders.PO_NUMBER','=','purchase_order_gr.po_no')
                // ->
                ->groupBy('po_no','vendor_id')->get();
        
        foreach( $getPoGR as $key => $rows ) {
            // $purchaseOrder = \App\Models\PurchaseOrder::where
        }
        dd($getPoGR);
    }
}
