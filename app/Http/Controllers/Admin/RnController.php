<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rn;
use App\Models\Material;
use App\Models\PurchasingGroup;
use App\Models\DepartmentCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('rn_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rn = Rn::all();

        return view('admin.rn.index', compact('rn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('rn_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category = DepartmentCategory::all();
        $material = Material::all();
        $purchasingGroups = PurchasingGroup::all();

        return view('admin.rn.create', compact('category', 'material', 'purchasingGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rn = Rn::create($request->all());

        return redirect()->route('admin.rn.index')->with('status', trans('cruds.masterrn.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('rn_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rn = Rn::findOrFail($id);

        return view('admin.rn.show', compact('rn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('rn_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rn = Rn::findOrFail($id);
        $category = DepartmentCategory::all();

        return view('admin.rn.edit', compact('rn', 'category'));
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
        $rn = Rn::findOrFail($id);
        
        $rn->code = $request->get('code');
        $rn->name = $request->get('name');
        $rn->departemen_peminta = $request->get('departemen_peminta');
        $rn->status = $request->get('status');

        $rn->save();
        
        return redirect()->route('admin.rn.index')->with('status', trans('cruds.masterrn.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('rn_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Rn::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "rn deleted successfully";
        } else {
            $success = true;
            $message = "rn not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
