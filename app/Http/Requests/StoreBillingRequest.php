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
            'ppn' => [
                'required',
            ],
            'dpp' => [
                'required',
            ],
            'no_rekening' => [
                'required',
            ],
            'search-po' => [
                'required',
            ],
            'qty' => [
                'required',
                'array',
                'min:1'
            ],
            'qty.*' => [
                'required',
            ],
            'material' => [
                'required',
                'array',
                'min:1'
            ],
            'material.*' => [
                'required'
            ],
            'description' => [
                'required',
                'array',
                'min:1'
            ],
            'description.*' => [
                'required'
            ],
            'po_no' => [
                'required',
                'array',
                'min:1'
            ],
            'po_no.*' => [
                'required'
            ],
            'PO_ITEM' => [
                'required',
                'array',
                'min:1'
            ],
            'PO_ITEM.*' => [
                'required'
            ],
            'doc_gr' => [
                'required',
                'array',
                'min:1'
            ],
            'doc_gr.*' => [
                'required'
            ],
            'item_gr' => [
                'required',
                'array',
                'min:1'
            ],
            'item_gr.*' => [
                'required'
            ],
            'posting_date' => [
                'required',
                'array',
                'min:1'
            ],
            'posting_date.*' => [
                'required'
            ],
        ];
    }
}
