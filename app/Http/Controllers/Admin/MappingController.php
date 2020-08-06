<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PurchasingGroup;
use App\Models\UserMap;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MappingController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = UserMap::all();

        return view('admin.mapping.index', compact('model'));
    }

    public function create ()
    {
        $users = User::all();
        $prg = PurchasingGroup::all();

        return view('admin.mapping.create', compact('users', 'prg'));
    }

    public function store (Request $request)
    {
        $model = UserMap::create([
            'user_id' => $request->get('user_id'),
            'purchasing_group_code' => implode(',',$request->get('purchasing_group_code')),
        ]);

        return redirect()->route('admin.mapping.index')->with('success', 'User map has been inserted successfully');
    }

    public function show ($id)
    {

    }

    public function edit ($id)
    {
        $model = UserMap::find($id);
        $users = User::all();
        $prg = PurchasingGroup::all();

        return view('admin.mapping.edit', compact('model', 'users','prg'));
    }

    public function update (Request $request, $id)
    {
        $model = UserMap::find($id);
        $model->user_id = $request->get('user_id');
        $model->purchasing_group_code = implode(',',$request->get('purchasing_group_code'));
        $model->save();

        return redirect()->route('admin.mapping.index')->with('success', 'User map has been updated successfully');
    }

    public function destroy (Request $request, $id)
    {
        $model = UserMap::find($id);

        if ($model->delete()) {
            return redirect()->route('admin.mapping.index')->with('success', 'User map has been removed successfully');
        }
    }
}
