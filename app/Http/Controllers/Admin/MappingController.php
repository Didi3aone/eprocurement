<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plant;
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
        $plants = Plant::get();

        return view('admin.mapping.create', compact('users', 'plants'));
    }

    public function store (Request $request)
    {
        $model = UserMap::create([
            'nik' => $request->get('nik'),
            'plant' => $request->get('plant'),
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
        $plants = Plant::get();

        return view('admin.mapping.edit', compact('model', 'users', 'plants'));
    }

    public function update (Request $request, $id)
    {
        $model = UserMap::find($id);
        $model->nik = $request->get('nik');
        $model->plant = $request->get('plant');
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
