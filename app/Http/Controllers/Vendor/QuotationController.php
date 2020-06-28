<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrdersDetail;
use App\Models\Vendor\Quotation;
use App\Models\Vendor\QuotationDetail;
use App\Models\Vendor\Wholesale;
use App\Models\Vendor;
use App\Models\BiddingHistory;
use SoapClient;
// use Gate;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    public function index ()
    {
        $quotation = Quotation::select(
            '*',
            \DB::raw('(
                select count(*) as count 
                from bidding_history 
                where quotation_id = quotation.id 
                    and vendor_id = ' . Auth::user()->id . ' 
                group by quotation_id
            )'),
            'quotation_details.id as detail_id', 'quotation_details.*'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', 'quotation.id')
            ->where('quotation_details.vendor_id', Auth::user()->id)
            ->orderBy('quotation.id', 'desc')
            ->get();

        return view('vendor.quotation.index', compact('quotation'));
    }

    public function online ()
    {
        $quotation = Quotation::select(
            \DB::raw('quotation.id as id'),
            'quotation.status',
            'quotation.model',
            'quotation.po_no',
            'quotation.leadtime_type',
            'quotation.purchasing_leadtime',
            'quotation.start_date',
            'quotation.expired_date',
            'quotation.qty',
            'quotation_details.quotation_order_id',
            \DB::raw('(
                select count(*) as count 
                from bidding_history 
                where quotation_id = quotation.id 
                    and vendor_id = ' . Auth::user()->id . '
                group by quotation_id
            )'),
            'quotation_details.id as detail_id',
            'quotation_details.*'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', 'quotation.id')
            ->where('quotation_details.vendor_id', Auth::user()->code)
            ->where('quotation.status', Quotation::Bidding)
            ->orderBy('quotation.id', 'desc')
            ->get();

        return view('vendor.quotation.online', compact('quotation'));
    }

    public function onlineDetail ($id)
    {
        $quotation = Quotation::select(
            'quotation.id as id',
            'quotation_details.id as detail_id',
            'quotation.status',
            'quotation.po_no',
            'quotation.model',
            'quotation.leadtime_type',
            'quotation.purchasing_leadtime',
            'quotation.target_price',
            'quotation.start_date',
            'quotation.expired_date',
            'quotation.qty'
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', '=', 'quotation.id')
            ->where('quotation.id', $id)
            ->first();

        $data = QuotationDetail::where('quotation_order_id', $id)
            ->get();

        return view('vendor.quotation.online-detail', compact('quotation', 'data', 'id'));
    }

    public function repeatDetail ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.repeat-detail', compact('quotation'));
    }

    public function approveRepeat (Request $request)
    {
        $id = $request->get('id');

        $quotation = Quotation::find($id);
        $vendor_id = @$quotation->vendor_id;
        $vendor = Vendor::find($vendor_id);
        // create po
        $quotation->approval_status = 2;
        $quotation->update();

        \DB::beginTransaction();
        try {
           
            \DB::commit();

            return redirect()->route('vendor.quotation-repeat')->with('status', trans('cruds.quotation.alert_success_quotation'));
        } catch (Exception $e) {
            \DB::rollBack();
        }
    }

    public function direct ()
    {
        $quotation = Quotation::select(
            'quotation.id',
            'quotation.po_no',
            'quotation.approval_status',
            \DB::raw('sum(quotation_details.qty) as total_qty'),
            \DB::raw('sum(quotation_details.price) as total_price')
        )
            ->join('quotation_details', 'quotation_details.quotation_order_id', '=', 'quotation.id')
            ->where('quotation.vendor_id', Auth::user()->code)
            ->where('quotation.status', 2)
            ->orderBy('quotation.id', 'desc')
            ->groupBy('quotation.id')
            ->get();

        return view('vendor.quotation.direct', compact('quotation'));
    }

    public function directDetail ($id)
    {
        $quotation = Quotation::find($id);

        return view('vendor.quotation.direct-detail', compact('quotation'));
    }

    public function saveBid (Request $request)
    {
        $target_price = str_replace('.', '', $request->get('target_price'));

        if (empty($request->get('min')))
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Min cannot be zero!');

        if (empty($request->get('max')))
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Max cannot be zero!');

        if (empty($request->get('price')))
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Price cannot be zero!');

        if (empty($request->get('target_price')) && $request->get('model') == 1)
            return redirect()->route('vendor.quotation-online-detail', $request->get('detail_id'))->with('status', 'Price cannot be zero!');

        \DB::beginTransaction();

        $id = $request->get('id');

        try {
            $quotation = Quotation::find($id);
            $quotation->target_price = $target_price;
            $quotation->save();

            $names = $request->get('name');
            $mins = $request->get('min');
            $maxs = $request->get('max');
            $prices = $request->get('price');

            for ($i = 0; $i < count($mins); $i++) {
                $wholesale = new Wholesale();
                $wholesale->quotation_id = $id;
                $wholesale->name = isset($names[$i]) ? $names[$i] : '';
                $wholesale->min = isset($mins[$i]) ? $mins[$i] : '';
                $wholesale->max = isset($maxs[$i]) ? $maxs[$i] : '';
                $wholesale->price = isset($prices[$i]) ? $prices[$i] : '';
                $wholesale->save();
            }

            $vendors = QuotationDetail::where('quotation_order_id', $id)
                ->where('vendor_id', '<>', Auth::user()->id)
                // ->where('vendor_price', $maxPrice)
                ->orderBy('id', 'desc')
                ->get();

            \DB::commit();

            return view('vendor.quotation.bid', compact('quotation', 'vendors'));
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }
    }

    public function bid ($id)
    {
        $quotation = Quotation::find($id);
        $maxPrice = QuotationDetail::where('quotation_order_id', $id)
            ->where('vendor_id', '<>', Auth::user()->id)
            ->whereNotNull('vendor_price')
            ->max('vendor_price');

        $vendors = null;
        
        if (!empty($maxPrice)) {
            $vendors = QuotationDetail::where('quotation_order_id', $id)
                ->where('vendor_id', '<>', Auth::user()->id)
                ->where('vendor_price', $maxPrice)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('vendor.quotation.bid', compact('quotation', 'vendors'));
    }

    public function store (Request $request)
    {
        $vendor_price = str_replace('.', '', $request->get('vendor_price'));

        if ($vendor_price > $request->get('target_price'))
            return redirect()->route('vendor.quotation-edit', $request->get('id'))
                ->with('error', trans('cruds.quotation.alert_error_price') . ', target price = ' . $request->get('target_price'));

        \DB::beginTransaction();

        try {
            $filename = '';
            
            if ($request->file('upload_file')) {
                $path = 'quotation/';
                $file = $request->file('upload_file');
                
                $filename = $file->getClientOriginalName();
        
                $file->move($path, $filename);
        
                $real_filename = public_path($path . $filename);
            }
    
            $quotation = QuotationDetail::where('quotation_order_id', $request->get('id'))->first();
            $quotation->upload_file = $filename;
            $quotation->vendor_leadtime = $request->get('vendor_leadtime');
            $quotation->vendor_price = $vendor_price;
            $quotation->notes = $request->get('notes');
            $quotation->save();

            $history = new BiddingHistory;
            $history->pr_no = $request->get('po_no');
            $history->vendor_id = Auth::user()->id;
            $history->quotation_id = $request->get('id');
            $history->save();

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            dd($e);
        }

        return redirect()->route('vendor.quotation-online')->with('status', trans('cruds.quotation.alert_success_quotation'));
    }
}