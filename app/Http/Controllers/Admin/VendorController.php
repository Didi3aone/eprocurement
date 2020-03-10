<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVendorRequest;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\Vendor;
use App\Models\Department;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vendor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::all();

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        abort_if(Gate::denies('vendor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::all()->pluck('name', 'id');

        return view('admin.vendors.create', compact('departments'));
    }

    public function store(StoreVendorRequest $request)
    {
        $vendor = Vendor::create($request->all());
        // $vendor->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.vendors.index');
    }

    public function edit(Vendor $vendor)
    {
        abort_if(Gate::denies('vendor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all()->pluck('title', 'id');

        $vendor->load('permissions');

        return view('admin.vendors.edit', compact('permissions', 'role'));
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->all());
        $vendor->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.vendors.index');
    }

    public function show(Vendor $vendor)
    {
        abort_if(Gate::denies('vendor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $vendor->load('permissions');

        return view('admin.vendors.show');
    }

    public function destroy(Vendor $vendor)
    {
        abort_if(Gate::denies('vendor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendor->delete();

        return back();
    }

    public function massDestroy(MassDestroyVendorRequest $request)
    {
        Vendor::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
