<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestNotes;
use App\Models\RequestNotesDetail;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RequestNoteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('request_notes_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rn = RequestNotesDetail::where('is_available_stock',0)->get();
        return view('admin.purchase-request.rn.index',compact('rn'));
    }

    // public function create ()
    // {
    //     abort_if(Gate::denies('request_notes_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.purchase-request.rn.create');
    // }
}
