<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate, DB;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reporting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $service = \App\Models\PurchaseRequestsDetail::join('purchase_requests','purchase_requests.id','=','purchase_requests_details.request_id')
        //             ->join('purchase_orders_details','purchase_orders_details.request_detail_id','=','purchase_requests_details.id')
        //             ->join('purchasing_groups','purchasing_groups.code','=','purchase_requests_details.purchasing_group_code')
        //             ->select(
        //                 'purchase_requests_details.purchasing_group_code as PurchasingGroup',
        //                 'purchasing_groups.description',
        //                 \DB::raw('count(purchase_requests_details.*) as DocOutstanding')
        //             )
        //             ->whereNotNull('purchase_requests.PR_NO')
        //             ->groupBy('purchase_requests_details.purchasing_group_code',
        //             'purchasing_groups.description')
        //             ->get();

        $service = DB::connection('pgsql')
                        ->table('vw_sla_ishow')
                        ->select('purchasing_group_code','pg_desc', 
                                    DB::raw('count(*) as total, ROUND(AVG(date_diff)) as rata, MIN(date_diff) as max_date'))
                        ->where('is_show','tampil')
                    //    ->groupBy('purchasing_group_code','pg_desc')
                        ->groupBy('purchasing_group_code','pg_desc')
                        ->get();

        $total_doc = DB::connection('pgsql')
                        ->table('vw_sla_ishow')
                        ->where('is_show','tampil')
                        ->count();
        // dd($service);
        return view('admin.report.index-service-level',\compact('service','total_doc'));
    }

    public function detail($id)
    {   
        $data = DB::connection('pgsql')
                        ->table('vw_sla_ishow')
                        ->where('is_show','tampil')
                        ->where('purchasing_group_code',  $id)
                        ->get();

        return view('admin.report.detail-service-level',\compact('data'));
    }
}