<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepartmentCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class DepartmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('department_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category = DepartmentCategory::all();
        return view('admin.department.category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.department.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = DepartmentCategory::create($request->all());

        return redirect()->route('admin.department-category.index')->with('status', trans('cruds.masterCategoryDept.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DepartmentCategory::findOrFaile($id);

        return view('admin.department.category.create',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = DepartmentCategory::findOrFail($id);

        return view('admin.department.category.edit',compact('category'));
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
        $category = DepartmentCategory::findOrFail($id);
        
        $category->code = $request->get('code');
        $category->name = $request->get('name');

        $category->save();
        
        return redirect()->route('admin.department-category.index')->with('status', trans('cruds.masterCategoryDept.alert_success_update'));

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
}
