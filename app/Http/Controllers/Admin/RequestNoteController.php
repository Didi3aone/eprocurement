<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchasingGroup;
use App\Models\RequestNotes;
use App\Models\RequestNotesDetail;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RequestNoteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('request_notes_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rn = RequestNotes::with([
                'requestDetail' => function ($q) {
                    $q->where('is_available_stock',3);
                }
            ])
            ->get();
        return view('admin.purchase-request.rn.index',compact('rn'));
    }

    public function create ()
    {
        // abort_if(Gate::denies('request_notes_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchasingGroups = PurchasingGroup::all();

        return view('admin.purchase-request.rn.create', compact('purchasingGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_note = RequestNotes::create($request->all());
        
        for ($i = 0; $i < count($request->input('material_id')); $i++) {
            $detail = new RequestNotesDetail;
            $detail->request_id = $request_note->id;
            $detail->material_id = $request->input('material_id')[$i];
            $detail->rn_description = $request->input('rn_description')[$i];
            $detail->rn_qty = $request->input('rn_qty')[$i];
            $detail->rn_unit = $request->input('rn_unit')[$i];
            $detail->rn_notes = $request->input('rn_notes')[$i];
            $detail->save();
        }

        return redirect()->route('admin.request-note.index')->with('status', trans('cruds.request_note.alert_success_insert'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('request-note_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request_note = RequestNotes::findOrFail($id);

        return view('admin.request-note.show', compact('request_note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('request-note_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request_note = RequestNotes::findOrFail($id);

        return view('admin.request-note.edit', compact('request_note'));
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
        $request_note = RequestNotes::findOrFail($id);
        $request_note->code = $request->get('code');
        $request_note->description = $request->get('description');
        $request_note->save();
        
        return redirect()->route('admin.request-note.index')->with('status', trans('cruds.request_note.alert_success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('request-note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = RequestNotes::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Purchasing Group deleted successfully";
        } else {
            $success = true;
            $message = "Purchasing Group not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
