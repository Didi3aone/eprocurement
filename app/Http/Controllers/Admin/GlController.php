<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Gl;
use App\Imports\GlsImport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class GlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('gl_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gls = Gl::all();

        return view('admin.gl.index', compact('gls'));
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('gl_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate($request, [
            'xls_file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        $path = 'xls/';
        $file = $request->file('xls_file');
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        Excel::import(new GlsImport, public_path($path . $filename));

        return redirect('admin/gl')->with('success', 'Init GL has been successfully imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('gl_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gl.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gl = Gl::create($request->all());

        return redirect()->route('admin.gl.index')->with('status', trans('cruds.gl.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('gl_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gl = Gl::findOrFail($id);

        return view('admin.gl.show', compact('gl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('gl_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gl = Gl::findOrFail($id);

        return view('admin.gl.edit', compact('gl'));
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
        $gl = Gl::findOrFail($id);
        $gl->code = $request->get('code');
        $gl->account = $request->get('account');
        $gl->balance = $request->get('balance');
        $gl->short_text = $request->get('short_text');
        $gl->acct_long_text = $request->get('acct_long_text');
        $gl->long_text = $request->get('long_text');
        $gl->save();
        
        return redirect()->route('admin.gl.index')->with('status', trans('cruds.gl.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('gl_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Gl::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Init GL deleted successfully";
        } else {
            $success = true;
            $message = "Init GL not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
