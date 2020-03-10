<?php

namespace App\Http\Requests;

use App\Models\Vendor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreVendorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('vendor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'no_vendor' => [
                'required',
            ],
            'nama_vendor' => [
                'required',
            ],
            'department_peminta' => [
                'required',
            ],
            'status' => [
                'required',
            ],
            'permissions.*' => [
                'integer',
            ],
            'permissions'   => [
                'required',
                'array',
            ],
        ];
    }
}
