<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);

        //PR TOTAL
        $prTotalBefore = \App\Models\PurchaseRequest::where('purchase_requests_details.qty','>',0)
                    ->join('purchase_requests_details','purchase_requests_details.request_id','=','purchase_requests.id')
                    ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
                    // ->groupBy('purchase_requests.id')
                    // ->distinct()
                    ->count();
                    
        $queryPr = \App\Models\PurchaseRequestsDetail::select(
            \DB::raw('purchase_requests_details.id as id'),
            'purchase_requests_details.request_id',
            'purchase_requests_details.description',
            'purchase_requests_details.qty',
            'purchase_requests_details.unit',
            'purchase_requests_details.notes',
            'purchase_requests_details.price',
            'purchase_requests_details.preq_item',
            'purchase_requests_details.preq_name',
            'purchase_requests_details.plant_code',
            'purchase_requests_details.short_text',
            'purchase_requests_details.storage_location',
            'purchase_requests_details.material_group',
            'purchase_requests_details.purchasing_group_code',
            'purchase_requests_details.material_id',
            'purchase_requests_details.delivery_date',
            \DB::raw('purchase_requests_details.request_no as rn_no'),
            'purchase_requests_details.release_date',
            \DB::raw('purchase_requests.request_no as pr_no'),
            'purchase_requests.request_date',
            'purchase_requests.PR_NO',
            'purchase_requests.total',
            'purchase_requests.doc_type',
            'purchase_requests.id as uuid'
        )
            ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_requests_details.request_id')
            ->whereNotNull('purchase_requests.PR_NO')
            ->where('purchase_requests_details.qty', '>', 0)
            ->where('purchase_requests_details.is_validate', \App\Models\PurchaseRequestsDetail::YesValidate)
            ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
            ->whereIn('purchase_requests_details.status_approval', [\App\Models\PurchaseRequestsDetail::Approved, \App\Models\PurchaseRequestsDetail::ApprovedPurchasing])
            // ->where('purchase_requests_details.line_no', '0000000001')
            //     ->orWhere('purchase_requests_details.line_no', '000000000')
            // ->where(function ($query) {
            //     $query->where('purchase_requests_details.status_approval', PurchaseRequestsDetail::Approved)
            //         ->orWhere('purchase_requests_details.status_approval', PurchaseRequestsDetail::ApprovedPurchasing);
            // })
            ->whereIn('purchase_requests.status_approval', [\App\Models\PurchaseRequest::ApprovedDept, \App\Models\PurchaseRequest::ApprovedProc])
            ->get();

        $prTotal = count($queryPr);


        //PO TOTAL
        if( \Auth::user()->roles[0]->id == 1 ) {
            $queryPo = \App\Models\PurchaseOrdersDetail::join('purchase_orders', 'purchase_orders.id', '=', 'purchase_orders_details.purchase_order_id')
                ->leftJoin('master_acps', 'master_acps.id', '=', 'purchase_orders_details.acp_id')
                ->leftJoin('vendors', 'vendors.code', '=', 'purchase_orders.vendor_id')
                // ->join('quotation','quotation.id','=','purchase_orders.quotation_id')
                ->where('purchase_orders.status_approval', \App\Models\PurchaseOrder::Approved)
                ->where('is_active', \App\Models\PurchaseOrdersDetail::Active)
                // ->where('quotation.status',PurchaseOrder::POrepeat)
                ->select(
                    'purchase_orders_details.purchasing_document',
                    'purchase_orders_details.PO_ITEM',
                    'purchase_orders_details.material_id',
                    'purchase_orders_details.short_text',
                    'purchase_orders_details.storage_location',
                    'purchase_orders_details.qty',
                    'purchase_orders_details.qty_gr',
                    'purchase_orders_details.qty_billing',
                    'purchase_orders_details.unit',
                    'purchase_orders_details.currency as original_currency',
                    'purchase_orders_details.original_price',
                    'purchase_orders.currency',
                    'purchase_orders_details.price',
                    'purchase_orders_details.tax_code',
                    'purchase_orders_details.id as detail_id',
                    'purchase_orders_details.request_no',
                    'purchase_orders_details.plant_code',
                    'purchase_orders_details.purchasing_group_code',
                    'purchase_orders.po_date',
                    'purchase_orders.PO_NUMBER',
                    'purchase_orders.id',
                    'purchase_orders.vendor_id',
                    'master_acps.acp_no',
                    'vendors.name as vendor'
                )->get();
            $poTotal = count($queryPo);
            //$poTotal = \App\Models\PurchaseOrder::count();
        } else {
            $queryPo = \App\Models\PurchaseOrdersDetail::join('purchase_orders', 'purchase_orders.id', '=', 'purchase_orders_details.purchase_order_id')
                ->leftJoin('master_acps', 'master_acps.id', '=', 'purchase_orders_details.acp_id')
                ->leftJoin('vendors', 'vendors.code', '=', 'purchase_orders.vendor_id')
                // ->join('quotation','quotation.id','=','purchase_orders.quotation_id')
                ->where('purchase_orders.status_approval', \App\Models\PurchaseOrder::Approved)
                ->where('is_active', \App\Models\PurchaseOrdersDetail::Active)
                ->where('purchase_orders.created_by',\Auth::user()->user_id)
                // ->where('quotation.status',PurchaseOrder::POrepeat)
                ->select(
                    'purchase_orders_details.purchasing_document',
                    'purchase_orders_details.PO_ITEM',
                    'purchase_orders_details.material_id',
                    'purchase_orders_details.short_text',
                    'purchase_orders_details.storage_location',
                    'purchase_orders_details.qty',
                    'purchase_orders_details.qty_gr',
                    'purchase_orders_details.qty_billing',
                    'purchase_orders_details.unit',
                    'purchase_orders_details.currency as original_currency',
                    'purchase_orders_details.original_price',
                    'purchase_orders.currency',
                    'purchase_orders_details.price',
                    'purchase_orders_details.tax_code',
                    'purchase_orders_details.id as detail_id',
                    'purchase_orders_details.request_no',
                    'purchase_orders_details.plant_code',
                    'purchase_orders_details.purchasing_group_code',
                    'purchase_orders.po_date',
                    'purchase_orders.PO_NUMBER',
                    'purchase_orders.id',
                    'purchase_orders.vendor_id',
                    'master_acps.acp_no',
                    'vendors.name as vendor'
                )->get();
            $poTotal = count($queryPo);
            //$poTotal = \App\Models\PurchaseOrder::where('created_by',\Auth::user()->user_id)->count();
        }

        //ACP TOTAL
        if( \Auth::user()->roles[0]->id == 1 ) {
            //$acpTotal = \App\Models\AcpTable::count();
            $query = \App\Models\AcpTable::select(
                        'master_acps.id',
                        'master_acps.acp_no',
                        'master_acps.status_approval',
                        'master_acps.is_project',
                        'master_acps.created_at',
                        'vendors.company_name',
                        'master_acp_materials.currency',
                        \DB::raw('sum(master_acp_materials.total_price) as total'),
                    )
                    ->join('master_acp_vendors','master_acp_vendors.master_acp_id', '=', 'master_acps.id')
                    ->join('vendors','vendors.code', '=', 'master_acp_vendors.vendor_code')
                    ->join('master_acp_materials', function($join)
                        {
                            $join->on('master_acp_materials.master_acp_id', '=', 'master_acp_vendors.master_acp_id');
                            $join->on('master_acp_materials.master_acp_vendor_id', '=', 'master_acp_vendors.vendor_code');
                        })
                    ->where('master_acp_vendors.is_winner' , 1)
                    ->groupBy(
                        'master_acps.id',
                        'master_acps.acp_no',
                        'master_acps.status_approval',
                        'master_acps.is_project',
                        'master_acps.created_at',
                        'vendors.company_name',
                        'master_acp_materials.currency',
                    )->get();
                $acpTotal = count($query);
        }elseif(\Auth::user()->roles[0]->id == 9) {
            $acpTotal = \App\Models\Vendor\QuotationApproval::where('nik', \Auth::user()->user_id)
                    ->join('master_acps','master_acps.id','=','quotation_approvals.acp_id')
                    ->join('master_acp_materials','master_acp_materials.master_acp_id','master_acps.id')
                    ->join('vendors','vendors.code','master_acp_materials.master_acp_vendor_id')
                    ->where('flag', \App\Models\Vendor\QuotationApproval::NotYetApproval)
                    ->where('acp_type', 'ACP')
                    ->groupBy(
                        'master_acps.id',
                        'quotation_approvals.nik',
                        'master_acps.acp_no',
                        'vendors.company_name',
                        'master_acps.status_approval',
                        'master_acp_materials.currency',
                        'quotation_approvals.flag'
                    )
                    ->count();
            //$acpTotal = \App\Models\AcpTable::where('created_by',\Auth::user()->user_id)->count();
        }elseif(\Auth::user()->roles[0]->id == 3){
            $query = \App\Models\AcpTable::select(
                        'master_acps.id',
                        'master_acps.acp_no',
                        'master_acps.status_approval',
                        'master_acps.is_project',
                        'master_acps.created_at',
                        'vendors.company_name',
                        'master_acp_materials.currency',
                        \DB::raw('sum(master_acp_materials.total_price) as total'),
                    )
                    ->join('master_acp_vendors','master_acp_vendors.master_acp_id', '=', 'master_acps.id')
                    ->join('vendors','vendors.code', '=', 'master_acp_vendors.vendor_code')
                    ->join('master_acp_materials', function($join)
                        {
                            $join->on('master_acp_materials.master_acp_id', '=', 'master_acp_vendors.master_acp_id');
                            $join->on('master_acp_materials.master_acp_vendor_id', '=', 'master_acp_vendors.vendor_code');
                        })
                    ->where('master_acp_vendors.is_winner' , 1)
                    ->where('master_acps.created_by', \Auth::user()->nik)
                    ->groupBy(
                        'master_acps.id',
                        'master_acps.acp_no',
                        'master_acps.status_approval',
                        'master_acps.is_project',
                        'master_acps.created_at',
                        'vendors.company_name',
                        'master_acp_materials.currency',
                    )->get();
                $acpTotal = count($query);
        }else{
            $acpTotal = 0;
        }
        return view('home',\compact('prTotal','poTotal','acpTotal'));
    }
}
