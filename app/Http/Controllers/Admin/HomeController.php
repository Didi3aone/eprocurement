<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        //dd(\Auth::user()->roles[0]->id);
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);
        $prTotal = \App\Models\PurchaseRequest::where('purchase_requests_details.qty','>',0)
                    ->join('purchase_requests_details','purchase_requests_details.request_id','=','purchase_requests.id')
                    ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
                    // ->groupBy('purchase_requests.id')
                    // ->distinct()
                    ->count();
        if( \Auth::user()->roles[0]->id == 1 ) {
            $poTotal = \App\Models\PurchaseOrder::count();
        } else {
            $poTotal = \App\Models\PurchaseOrder::where('created_by',\Auth::user()->user_id)->count();
        }

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
