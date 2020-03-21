<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ApprovalPr;
// use App\Imports\ApprovalPrImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ApprovalPrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('approval_purchase_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $approval_prs = ApprovalPr::all();

        return view('admin.purchase-request.approval_pr.index', compact('approval_prs'));
    }

    // public function import(Request $request)
    // {
    //     // abort_if(Gate::denies('approval_purchase_request_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $this->validate($request, [
    //         'xls_file' => 'required|file|mimes:csv,xls,xlsx',
    //     ]);

    //     $path = 'xls/';
    //     $file = $request->file('xls_file');
    //     $filename = $file->getClientOriginalName();

    //     $file->move($path, $filename);

    //     Excel::import(new ApprovalPrImport, public_path($path . $filename));

    //     return redirect('admin/approval_pr')->with('success', 'approval_pr has been successfully imported');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('approval_purchase_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.purchase-request.approval_pr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $approval_pr = ApprovalPr::create($request->all());

        return redirect()->route('admin.approval_pr.index')->with('status', trans('cruds.approval_pr.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('approval_purchase_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $approval_pr = ApprovalPr::findOrFail($id);

        return view('admin.purchase-request.approval_pr.show', compact('approval_pr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('approval_purchase_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $approval_pr = ApprovalPr::findOrFail($id);

        return view('admin.purchase-request.approval_pr.edit', compact('approval_pr'));
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
        $approval_pr = ApprovalPr::findOrFail($id);
        $approval_pr->pr_no = $request->get('pr_no');
        $approval_pr->approval_position = $request->get('approval_position');
        $approval_pr->nik = $request->get('nik');
        $approval_pr->status = $request->get('status');
        $approval_pr->save();
        
        return redirect()->route('admin.approval_pr.index')->with('status', trans('cruds.approval_pr.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('approval_purchase_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = ApprovalPr::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Approval PR deleted successfully";
        } else {
            $success = true;
            $message = "Approval PR not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
