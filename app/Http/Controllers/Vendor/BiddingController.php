<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Bidding;
use App\Models\BiddingDetail;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class BiddingController extends Controller
{
    public function index ()
    {
        $biddings = Bidding::all();

        return view('vendor.bidding.index', compact('biddings'));
    }
}