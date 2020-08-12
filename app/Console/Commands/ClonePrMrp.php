<?php
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\TempPurchaseRequest;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsDetail;
use App\Models\Material;
 
class ClonePrMrp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CLONE:MRP';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone data From table temp';
    
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
        $getPrMRP = TempPurchaseRequest::where('is_clone',0)->get();
        if( empty($getPrMRP) ) {
            echo "..... No data found ......\n";
        } else {
            $this->output->progressStart(count($getPrMRP));
            foreach( $getPrMRP as $rows ) {
                sleep(1);
                $this->output->progressAdvance();
                $checkPrInsert = PurchaseRequest::where('PR_NO',$rows->PR_NO)->first();
                if( $checkPrInsert != null ) {
                    echo "PR NO ".$rows->PR_NO." already exist in database \n";
                } else  {
                    $purchaseRequest = new PurchaseRequest;
                    $purchaseRequest->request_no            = $this->generatePrNo();
                    $purchaseRequest->request_date          = \Carbon\Carbon::now()->format('Y-m-d');
                    $purchaseRequest->notes                 = "PR MRP FROM SAP";
                    $purchaseRequest->total                 = 0;
                    $purchaseRequest->doc_type              = $rows->doc_type;
                    $purchaseRequest->upload_file           = "NO_FILE";
                    $purchaseRequest->spv_id                = 9999;
                    $purchaseRequest->PR_NO                 = $rows->PR_NO;
                    $purchaseRequest->is_send_sap           = 'YES';
                    $purchaseRequest->status                = PurchaseRequest::Success;
                    $purchaseRequest->status_approval       = PurchaseRequest::ApprovedDept;
                    $purchaseRequest->is_validate           = PurchaseRequest::YesValidate;
                    $purchaseRequest->plant_code            = $rows->plant_code;
                    $purchaseRequest->save();
                    $getDetail = TempPurchaseRequest::where('PR_NO', $rows->PR_NO)->get()->toArray();
                    
                    for ($i=0; $i < count($getDetail); $i ++) { 
                        if( $rows->PR_NO == $getDetail[$i]['PR_NO'] ) { 
                            $materials = Material::where('code',$rows[$i]['material_id'])->first();
                            $purchaseRequestDetail                          = new PurchaseRequestsDetail;
                            $purchaseRequestDetail->request_id              = $purchaseRequest->id;
                            $purchaseRequestDetail->description             = $getDetail[$i]['description'] ??  $getDetail[$i]['short_text'];
                            $purchaseRequestDetail->category                = $getDetail[$i]['category'] ?? '';
                            $purchaseRequestDetail->qty                     = $getDetail[$i]['qty'] ?? '';
                            $purchaseRequestDetail->unit                    = $getDetail[$i]['unit'] ?? '';
                            $purchaseRequestDetail->notes                   = 'PR MRP';
                            $purchaseRequestDetail->price                   = 1;
                            $purchaseRequestDetail->material_id             = $getDetail[$i]['material_id'] ?? '';
                            $purchaseRequestDetail->gl_acct_code            = '';
                            $purchaseRequestDetail->request_no              = $getDetail[$i]['request_no'] ?? '';
                            $purchaseRequestDetail->plant_code              = $getDetail[$i]['plant_code'] ?? '';
                            $purchaseRequestDetail->purchasing_group_code   = $getDetail[$i]['purchasing_group_code'] ?? '';
                            $purchaseRequestDetail->preq_name               = $getDetail[$i]['preq_name'] ?? '';
                            $purchaseRequestDetail->storage_location        = $getDetail[$i]['storage_location'] ?? '';
                            $purchaseRequestDetail->material_group          = $getDetail[$i]['material_group'] ?? '';
                            $purchaseRequestDetail->cost_center_code        = '';
                            $purchaseRequestDetail->profit_center_code      = $materials->profit_center_code ?? 00;
                            $purchaseRequestDetail->delivery_date           = $getDetail[$i]['delivery_date'] ?? '';
                            $purchaseRequestDetail->release_date            = $getDetail[$i]['release_date'] ?? '';
                            $purchaseRequestDetail->account_assignment      = $getDetail[$i]['account_assignment'] ? $getDetail[$i]['account_assignment'] : "H";
                            $purchaseRequestDetail->delivery_date_category  = 'D';
                            $purchaseRequestDetail->text_id                 = 'PR';
                            $purchaseRequestDetail->text_form               = 'EN';
                            $purchaseRequestDetail->text_line               = $getDetail[$i]['text_line'] ?? '';
                            $purchaseRequestDetail->short_text              = $getDetail[$i]['short_text'] ?? '';
                            $purchaseRequestDetail->gr_ind                  = 1;
                            $purchaseRequestDetail->ir_ind                  = 1;
                            $purchaseRequestDetail->is_validate             = PurchaseRequest::YesValidate;
                            $purchaseRequestDetail->co_area                 = 'EGCA';
                            $purchaseRequestDetail->type_approval           = 888;
                            $purchaseRequestDetail->status_approval         = 704;
                            $purchaseRequestDetail->is_material             = 0;
                            $purchaseRequestDetail->preq_item               = $getDetail[$i]['preq_item'] ?? '';
                            $purchaseRequestDetail->package_no              = '000000000';
                            $purchaseRequestDetail->subpackage_no           = '000000000';
                            $purchaseRequestDetail->line_no                 = '000000000';
        
                            $purchaseRequestDetail->save();
                        }
                    }
                    
                    echo "PR No ".$rows->PR_NO." berhasil disimpan didatabase \n";
                }

                $temp = TempPurchaseRequest::find($rows->id);
                if( !empty($temp) ) {
                    $temp->is_clone = 1;
                    $temp->update();
                }


            }
        }
        // \DB::table('logs')->insert([
        //     'log_type' => 'Cron Get PR MRP',
        //     'id1' => 9999,
        //     'desc1' => 'Get PR MRP => Cronjob is running',
        //     'desc2' => 'Success',
        //     'desc3' => '',
        //     'created_at' => \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now(),
        //     'created_by' => 9999
        // ]);
        $this->output->progressFinish();
    }

    public static function generatePrNo()
    {
        $maxCode  = PurchaseRequest::max('request_no');
        if( empty( $maxCode) ) {
            $NextCode = 0000001;
        } else {
            $NextCode = substr($maxCode,9) + 1;
        }
        
        $DocNo = sprintf("%07s", $NextCode);

        return "PR/".date('m')."/".date('y')."/".$DocNo;
    }
}