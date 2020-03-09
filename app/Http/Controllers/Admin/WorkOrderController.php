<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangeHrm\Department;
use App\Models\OrangeHrm\DepartmentHead;
use App\Models\OrangeHrm\SuperiorUser;
use App\Models\WorkOrder;
use App\Models\WorkOrderHistoryLog;
use App\Models\WorkOrderModule;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkOrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('work_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrder = WorkOrder::all();

        return view('admin.work-order.list-wo.index', compact('workOrder'));
    }

    public function create()
    {
        abort_if(Gate::denies('work_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department =
            DepartmentHead::join('organization_unit_tbl', 'organization_structure_tbl.parent_org_id', '=', 'organization_unit_tbl.org_id')
                ->select('parent_org_id')
                ->groupBy('parent_org_id')
                ->get()
                ->map(function ($query) {
                    return Department::where('org_id', $query->parent_org_id)->first() ?? '';
                })->pluck('name', 'org_id');

        return view('admin.work-order.list-wo.create', compact('department'));
    }

    public function store(Request $request)
    {
        $file_upload = $this->fileUpload($request);
        $request->merge([ 'file_upload' => $file_upload ]);

        $work_order_number = $this->generateDocNo($request);
        $request->merge([ 'work_order_no' => $work_order_number ]);

        $workOrder = WorkOrder::create($request->all());

        $workOrderHistoryLog                 = new WorkOrderHistoryLog();
        $workOrderHistoryLog->work_order_id  = $workOrder->id;
        $workOrderHistoryLog->notes          = 'WO Need Follow Up';
        $workOrderHistoryLog->responsible_id = $workOrder->pic;
        $workOrderHistoryLog->status         = 'In Progress';
        $workOrderHistoryLog->save();

        return redirect()->route('admin.work-order.show', $workOrder->id);
    }

    public function show($id)
    {
        abort_if(Gate::denies('work_order_module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department =
            DepartmentHead::join('organization_unit_tbl', 'organization_structure_tbl.parent_org_id', '=', 'organization_unit_tbl.org_id')
                ->select('parent_org_id')
                ->groupBy('parent_org_id')
                ->get()
                ->map(function ($query) {
                    return Department::where('org_id', $query->parent_org_id)->first() ?? '';
                })->pluck('name', 'org_id');
        $workOrder  = WorkOrder::find($id);

        return view('admin.work-order.list-wo.show', compact('department', 'workOrder'));
    }

    public function edit(Request $request, WorkOrder $workOrder)
    {
        abort_if(Gate::denies('work_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department =
            DepartmentHead::join('organization_unit_tbl', 'organization_structure_tbl.parent_org_id', '=', 'organization_unit_tbl.org_id')
                ->select('parent_org_id')
                ->groupBy('parent_org_id')
                ->get()
                ->map(function ($query) {
                    return Department::where('org_id', $query->parent_org_id)->first() ?? '';
                })->pluck('name', 'org_id');

        if ($request->status == 'Reject') {
            return view('admin.work-order.list-wo.edit-reject', compact('workOrder', 'department'));
        }
        if ($request->status == 'Approve') {
            return view('admin.work-order.list-wo.edit-approve', compact('workOrder', 'department'));
        }
        if ($request->status == 'Re-Assign') {
            return view('admin.work-order.list-wo.edit-reassign', compact('workOrder', 'department'));
        }
        return view('admin.work-order.list-wo.edit', compact('workOrder', 'department'));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        if ($request->status == 'Re-Assign') {
            $request->merge([ 'notes' => $workOrder->notes . '<br>' . Auth::user()->name . ' ' . now() . ' :' . $request->notes ]);
            $request->merge(['status' => 'Not Started']);
            $workOrder->update($request->all());

            WorkOrderHistoryLog::where('work_order_id', $workOrder->id)->orderBy('id', 'desc')
                ->first()->update([ 'status' => 'Done', 'process_date' => now(), 'notes' => 'Work Order Re-Assigned to'. $workOrder->getPicName['display_name']]);
            $workOrderHistoryLog                 = new WorkOrderHistoryLog();
            $workOrderHistoryLog->work_order_id  = $workOrder->id;
            $workOrderHistoryLog->notes          = 'Work Order Re-assigned';
            $workOrderHistoryLog->responsible_id = $workOrder->pic;
            $workOrderHistoryLog->status         = 'In Progress';
            $workOrderHistoryLog->save();
        }

        if ($request->status == 'In Progress') {
            $request->merge([ 'notes' => $workOrder->notes . '<br>' . Auth::user()->name . ' ' . now() . ' :' . $request->notes ]);
            $workOrder->update($request->all());

            WorkOrderHistoryLog::where('work_order_id', $workOrder->id)->orderBy('id', 'desc')
                ->first()->update([ 'status' => 'Done', 'process_date' => now() ]);
            $workOrderHistoryLog                 = new WorkOrderHistoryLog();
            $workOrderHistoryLog->work_order_id  = $workOrder->id;
            $workOrderHistoryLog->notes          = 'Waiting to Complete';
            $workOrderHistoryLog->responsible_id = $workOrder->pic;
            $workOrderHistoryLog->status         = 'In Progress';
            $workOrderHistoryLog->save();
        }

        if ($request->status == 'Reject') {
            $request->merge([ 'notes' => $workOrder->notes . '<br>' . Auth::user()->name . ' ' . now() . ' :' . $request->notes ]);
            $workOrder->update($request->all());

            WorkOrderHistoryLog::where('work_order_id', $workOrder->id)->orderBy('id', 'desc')
                ->first()->update([ 'status' => 'Done', 'process_date' => now() ]);

            $workOrderHistoryLog                 = new WorkOrderHistoryLog();
            $workOrderHistoryLog->work_order_id  = $workOrder->id;
            $workOrderHistoryLog->notes          = 'Cancel/Reject by ' . Auth::user()->name;
            $workOrderHistoryLog->responsible_id = $workOrder->pic;
            $workOrderHistoryLog->status         = 'Done';
            $workOrderHistoryLog->save();

        }

        return redirect()->route('admin.work-order.show', $workOrder->id);
    }

    public function destroy(WorkOrderModule $workOrderModule)
    {
        abort_if(Gate::denies('work_order_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModule->delete();

        return back();
    }

    public function getWorkOrderModuleByDepartment($departmentId)
    {
        return WorkOrderModule::where('departmentId', $departmentId)->get();
    }

    public function getWorkOrderModuleData($id)
    {
        return WorkOrderModule::with('getPicName', 'getPicName.getSuperiorUser.getUserSupervisor')->where('id', $id)->first();
    }

    public function getWorkOrderModuleChildren($id)
    {
        return WorkOrderModule::where('parentId', $id)->get();
    }

    public function fileUpload($request)
    {
        $file_upload = [];
        if ($request->file_uploads) {
            foreach ($request->file_uploads as $file) {
                $filename = time() . '.' . $file->extension();
                $filePath = public_path() . '/files/uploads/';
                $file->move($filePath, $filename);
                $file_upload[] = $filename;
            }
        }
        $file_upload = serialize($file_upload);
        return $file_upload;
    }

    public function generateDocNo($request)
    {
        $department = Department::where('org_id', $request->departmentId)->first();
        $maxCode    = WorkOrder::count();
        $nextCode   = substr($maxCode, 0, 3) + 1;

        return "WO/" . $department->name . "/" . date('y') . "/" . $nextCode;
    }
}
