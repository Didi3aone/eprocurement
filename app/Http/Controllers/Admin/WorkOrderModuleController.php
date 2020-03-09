<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreWorkOrderModuleRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateWorkOrderModuleRequest;
use App\Models\OrangeHrm\Department;
use App\Models\OrangeHrm\DepartmentHead;
use App\Models\OrangeHrm\User;
use App\Models\WorkOrderModule;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkOrderModuleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('work_order_module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::doesnthave('parentSubModule')->where('created_by', Auth::id())->get();

        return view('admin.work-order.module.index', compact('workOrderModules'));
    }

    public function create()
    {
        abort_if(Gate::denies('work_order_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department =
            DepartmentHead::join('organization_unit_tbl', 'organization_structure_tbl.parent_org_id', '=', 'organization_unit_tbl.org_id')
                ->select('parent_org_id')
                ->groupBy('parent_org_id')
                ->get()
                ->map(function ($query) {
                    return Department::where('org_id', $query->parent_org_id)->first() ?? '';
                })->pluck('name', 'org_id');

        return view('admin.work-order.module.create', compact('department'));
    }

    public function store(StoreWorkOrderModuleRequest $request)
    {
        $user = WorkOrderModule::create($request->all());

        return redirect()->route('admin.work-order-module.index');
    }

    public function edit(WorkOrderModule $workOrderModule)
    {
        abort_if(Gate::denies('work_order_module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department =
            DepartmentHead::join('organization_unit_tbl', 'organization_structure_tbl.parent_org_id', '=', 'organization_unit_tbl.org_id')
                ->select('parent_org_id')
                ->groupBy('parent_org_id')
                ->get()
                ->map(function ($query) {
                    return Department::where('org_id', $query->parent_org_id)->first() ?? '';
                })->pluck('name', 'org_id');

        return view('admin.work-order.module.edit', compact('workOrderModule', 'department'));
    }

    public function update(UpdateWorkOrderModuleRequest $request, WorkOrderModule $workOrderModule)
    {
        $workOrderModule->update($request->all());

        return redirect()->route('admin.work-order-module.index');
    }

    public function destroy(WorkOrderModule $workOrderModule)
    {
        abort_if(Gate::denies('work_order_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModule->delete();

        return back();
    }

    public function indexSubModule($id)
    {
        abort_if(Gate::denies('work_order_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::find($id);

        return view('admin.work-order.module.sub-module.index', compact('workOrderModules'));
    }

    public function createSubModule($id)
    {
        abort_if(Gate::denies('work_order_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::find($id);
        $user             = User::all()->pluck('display_name', 'person_id');

        return view('admin.work-order.module.sub-module.create', compact('workOrderModules', 'user'));
    }

    public function storeSubModule($id, StoreWorkOrderModuleRequest $request)
    {
        $user = WorkOrderModule::create($request->all());

        return redirect("/admin/work-order-module/$id/sub-module/");
    }

    public function editSubModule($id, $subId)
    {
        abort_if(Gate::denies('work_order_module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::with([
            'submodule' => function ($query) use ($subId) {
                $query->where('id', $subId);
            },
        ])->where('id', $id)->first();

        $user = User::all()->pluck('display_name', 'person_id');

        return view('admin.work-order.module.sub-module.edit', compact('workOrderModules', 'user'));
    }

    public function updateSubModule($id, $subId, UpdateWorkOrderModuleRequest $request)
    {
        $workOrderModule = WorkOrderModule::find($subId);
        $workOrderModule->update($request->all());

        return redirect("/admin/work-order-module/$id/sub-module/");
    }

    public function destroySubModule($id, $subId)
    {
        abort_if(Gate::denies('work_order_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModule = WorkOrderModule::find($subId);

        $workOrderModule->delete();

        return back();
    }

    public function indexDetail($id, $subId)
    {
        abort_if(Gate::denies('work_order_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::with([
            'submodule' => function ($query) use ($subId) {
                $query->where('id', $subId);
            },
        ])->where('id', $id)->first();

        return view('admin.work-order.module.detail.index', compact('workOrderModules'));
    }

    public function createDetail($id, $subId)
    {
        abort_if(Gate::denies('work_order_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::with([
            'submodule' => function ($query) use ($subId) {
                $query->where('id', $subId);
            },
        ])->where('id', $id)->first();

        return view('admin.work-order.module.detail.create', compact('workOrderModules'));
    }

    public function storeDetail($id, $subId, StoreWorkOrderModuleRequest $request)
    {
        WorkOrderModule::create($request->all());

        return redirect("/admin/work-order-module/$id/sub-module/$subId/detail");
    }

    public function showDetail($id, $subId, $detailId)
    {
        $workOrderModules = WorkOrderModule::with([
            'submodule' => function ($query) use ($subId) {
                $query->where('id', $subId);
            },
        ])->where('id', $id)->first();

        $detailId = WorkOrderModule::find($detailId);

        return view('admin.work-order.module.detail.show', compact('workOrderModules', 'detailId'));
    }

    public function editDetail($id, $subId, $detailId)
    {
        abort_if(Gate::denies('work_order_module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::with([
            'submodule' => function ($query) use ($subId) {
                $query->where('id', $subId);
            },
        ])->where('id', $id)->first();

        $detailId = WorkOrderModule::find($detailId);

        return view('admin.work-order.module.detail.edit', compact('workOrderModules', 'detailId'));
    }

    public function updateDetail($id, $subId, $detailId, UpdateWorkOrderModuleRequest $request)
    {
        $workOrderModule = WorkOrderModule::find($detailId);
        $workOrderModule->update($request->all());
        return redirect("/admin/work-order-module/$id/sub-module/$subId/detail");
    }

    public function destroyDetail($id, $subId, $detailId)
    {
        abort_if(Gate::denies('work_order_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModule = WorkOrderModule::find($detailId);

        $workOrderModule->delete();

        return back();
    }
}
