<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PrPo;
use App\Models\PurchaseRequestsDetail;
use App\Models\PurchaseRequestsApproval;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\MasterRfqDetail;
use App\Models\Plant;
use App\Models\DocumentType;
use App\Models\UserMap;
use App\Models\Vendor;
use DB,Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('purchase_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userMapping = UserMap::where('nik', \Auth::user()->nik)->first();

        $materials = PurchaseRequestsDetail::select(
            \DB::raw('purchase_requests_details.id as id'),
            'purchase_requests_details.request_id',
            'purchase_requests_details.description',
            'purchase_requests_details.qty',
            'purchase_requests_details.unit',
            'purchase_requests_details.notes',
            'purchase_requests_details.price',
            'purchase_requests_details.material_id',
            \DB::raw('purchase_requests_details.request_no as rn_no'),
            'purchase_requests_details.release_date',
            \DB::raw('purchase_requests.request_no as pr_no'),
            'purchase_requests.request_date',
            'purchase_requests.total'
        )
            ->leftJoin('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
            ->leftJoin('master_materials', 'master_materials.code', '=', 'purchase_requests_details.material_id')
            ->where('master_materials.plant_code', $userMapping->plant)
            ->where('purchase_requests_details.is_validate', 1)
            ->where('purchase_requests_details.qty', '>', 0)
            ->where(function ($query) {
                $query->where('purchase_requests_details.status_approval', 704)
                    ->orWhere('purchase_requests_details.status_approval', 705);
            })
            ->orderBy('purchase_requests.created_at', 'desc')
            ->get();

        foreach ($materials as $row) {
            $row->uuid = $row->getAttributes()['id'];
        }

        return view('admin.purchase-request.index', compact('materials'));
    }

    protected function createPrPo ($ids, $quantities = null)
    {
        $max = PurchaseRequest::select(\DB::raw('count(id) as id'))->first()->id;
        $po_no = 'PO/' . date('m') . '/' . date('Y') . '/' . sprintf('%07d', ++$max);
        $ids = explode(',', $ids);

        if ($quantities)
            $quantities = explode(',', $quantities);

        $data = [];
        foreach ($ids as $i => $id) {
            $pr = PurchaseRequestsDetail::select(
                'purchase_requests_details.*',
                'purchase_requests.request_no as pr_no',
                'purchase_requests.request_date as request_date'
            )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
                ->where('purchase_requests_details.id', $id)
                ->first();

            $rfq = MasterRfqDetail::where('material', $pr->material_id)->first();

            if ($rfq)
                $pr->price = $rfq->net_order_price;

            if ($quantities[$i])
                $pr->qty = $quantities[$i];
                
            array_push($data, $pr);
        }

        $vendor = Vendor::orderBy('name')->get();

        return [
            'po_no' => $po_no,
            'data' => $data,
            'vendor' => $vendor,
            'top'    => \App\Models\PaymentTerm::all()
        ];
    }

    public function online (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);

        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.online', compact('data', 'po_no', 'vendor', 'uri'));
    }

    public function repeat (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);
        
        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];
        $top = $return['top'];

        $docTypes = DocumentType::where('type','2')->get();

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.repeat', compact('data', 'docTypes', 'po_no', 'vendor', 'uri','top'));
    }

    public function direct (Request $request, $ids, $quantities)
    {
        $ids = base64_decode($ids);
        $quantities = base64_decode($quantities);
        $return = $this->createPrPo($ids, $quantities);
        
        $data = $return['data'];
        $po_no = $return['po_no'];
        $vendor = $return['vendor'];

        $docTypes = DocumentType::get();

        $uri = [
            'ids' => base64_encode($ids),
            'quantities' => base64_encode($quantities)
        ];
        
        return view('admin.purchase-request.direct', compact('data', 'docTypes', 'po_no', 'vendor', 'uri'));
    }

 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDetail($id)
    {
        $prDetail = PurchaseRequestsDetail::where('request_id', $id)->get();
        $pr       = PurchaseRequest::find($id);
        $papproval = PurchaseRequestsApproval::where('purchase_request_id',$id)->orderBy('approval_position','asc')->get();

        return view('admin.purchase-request.pr.show-detail', compact('pr','prDetail','papproval'));
    }
}
