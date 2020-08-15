<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterShipToAdress;
use Gate, Artisan;
use Symfony\Component\HttpFoundation\Response;

class MasterShipToController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('ship_to_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $shipTo = MasterShipToAdress::all();
        return view('admin.master-ship.index',\compact('shipTo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('ship_to_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.master-ship.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'alamat' => 'required'
        ]);
        MasterShipToAdress::create($request->all());

        return redirect()->route('admin.ship-to.index')->with('status','Ship to has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('ship_to_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $shipTo = MasterShipToAdress::find($id);
        return view('admin.master-ship.show',\compact('shipTo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('ship_to_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $shipTo = MasterShipToAdress::find($id);
        return view('admin.master-ship.edit',\compact('shipTo'));
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
        $shipTo = MasterShipToAdress::find($id);

        $shipTo->name = $request->name;
        $shipTo->alamat = $request->alamat;

        $shipTo->update();

        return redirect()->route('admin.ship-to.index')->with('status','Ship to has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = MasterShipToAdress::find($id);
        $delete->delete();

        return redirect()->route('admin.ship-to.index')->with('status','Ship to has been deleted');
    }
}
