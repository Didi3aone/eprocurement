<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Vendor;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poRepeat = \App\Models\PurchaseOrder::where('vendor_id',\Auth::user()->code)
            ->where('status',\App\Models\PurchaseOrder::POrepeat)->count();
        $poDirect = \App\Models\PurchaseOrder::where('vendor_id',\Auth::user()->code)
            ->where('status',\App\Models\PurchaseOrder::POdirect)->count();

        $poRepeatChart =  \App\Models\PurchaseOrder::where('vendor_id',\Auth::user()->code)
                    ->select(\DB::raw("COUNT(*) as count"))
                    ->where('status',\App\Models\PurchaseOrder::POrepeat)
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("EXTRACT(MONTH FROM created_at)"))
                    ->pluck('count');
        $poDirectChart =  \App\Models\PurchaseOrder::where('vendor_id',\Auth::user()->code)
                    ->select(\DB::raw("COUNT(*) as count"))
                    ->where('status',\App\Models\PurchaseOrder::POdirect)
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("EXTRACT(MONTH FROM created_at)"))
                    ->pluck('count');

        return view('vendor.home',\compact('poRepeat','poDirect','poRepeatChart','poDirectChart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verifyVendorRegistration($token)
    {
        $vendor = Vendor::where('activate_token', $token)->first();

        if( $vendor ) {
            $vendor->update([
                'activate_token' => null,
                'status'         => 1
            ]);
            return redirect(route('vendor.login'))->with(['success' => 'Verifikasi Berhasil, Silahkan Login']);
        }

        return redirect(route('vendor.login'))->with(['error' => 'Invalid verify token']);
    }
}
