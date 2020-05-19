<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tgl_faktur'     => [
                'required',
            ],
            'tgl_invoice' => [
                'required',
            ],
            'nominal_inv_after_ppn' => [
                'required',
            ],
            'ppn' => [
                'required',
            ],
            'dpp' => [
                'required',
            ],
            'no_rekening' => [
                'required',
            ],
            'no_surat_jalan' => [
                'required',
            ],
            'tgl_surat_jalan' => [
                'required',
            ]
        ];
    }
}
