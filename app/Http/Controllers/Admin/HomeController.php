<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        $prTotal = \App\Models\PurchaseRequest::where('purchase_requests_details.qty','>',0)
                    ->join('purchase_requests_details','purchase_requests_details.request_id','=','purchase_requests.id')
                    // ->groupBy('purchase_requests.id')
                    ->distinct()
                    ->count();
        return view('home',\compact('prTotal'));
    }
}
