<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrderModule;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class WorkOrderModuleAllHierarchyController extends Controller {

    public function index()
    {
        abort_if(Gate::denies('work_order_all_module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workOrderModules = WorkOrderModule::doesnthave('parentSubModule')->get();

        return view('admin.work-order.all-hierarchy.index', compact('workOrderModules'));
    }
}
