<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreWorkOrderModuleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('work_order_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'     => [
                'required',
            ],
        ];
    }
}
