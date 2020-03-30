<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountAssignment;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

class AccountAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('account_assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $account_assignments = AccountAssignment::all();

        return view('admin.account_assignment.index', compact('account_assignments'));
    }

    public function select (Request $request)
    {
        $account_assignment = AccountAssignment::all();
        
        $data = [];
        foreach ($account_assignment as $row) {
            $data[$row->code] = $row->code . ' - ' . $row->description;
        }

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.account_assignment.create');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = 'xls/';
        $file = $request->file('xls_file');
        
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        $real_filename = public_path($path . $filename);

        Artisan::call('import:account_assignment', ['filename' => $real_filename]);

        return redirect('admin/account_assignment')->with('success', trans('cruds.account_assignment.success_import'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account_assignment = AccountAssignment::create($request->all());

        return redirect()->route('admin.account_assignment.index')->with('status', trans('cruds.account_assignment.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account_assignment = AccountAssignment::findOrFail($id);

        return view('admin.account_assignment.show', compact('account_assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account_assignment = AccountAssignment::findOrFail($id);

        return view('admin.account_assignment.edit', compact('account_assignment'));
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
        $account_assignment = AccountAssignment::find($id);
        $account_assignment->company_id = $request->input('company_id');
        $account_assignment->code = $request->input('code');
        $account_assignment->description = $request->input('description');
        $account_assignment->save();
        
        return redirect()->route('admin.account_assignment.index')->with('status', trans('cruds.account_assignment.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = AccountAssignment::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "account_assignment deleted successfully";
        } else {
            $success = true;
            $message = "account_assignment not found";
        }

        // return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
