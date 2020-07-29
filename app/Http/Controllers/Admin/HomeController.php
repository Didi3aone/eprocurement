<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        $userMapping = \App\Models\UserMap::where('user_id', \Auth::user()->user_id)->first();
        $userMapping = explode(',', $userMapping->purchasing_group_code);
        $prTotal = \App\Models\PurchaseRequest::where('purchase_requests_details.qty','>',0)
                    ->join('purchase_requests_details','purchase_requests_details.request_id','=','purchase_requests.id')
                    ->whereIn('purchase_requests_details.purchasing_group_code', $userMapping)
                    // ->groupBy('purchase_requests.id')
                    // ->distinct()
                    ->count();

        $poTotal = \App\Models\PurchaseOrder::where('created_by',\Auth::user()->user_id)->count();
                    // dd($prTotal);
        return view('home',\compact('prTotal','poTotal'));
    }
}
