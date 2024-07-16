<?php

namespace App\Http\Requests;

use Gate;
use App\Models\Price;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class StorePriceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('price_create');
    }

    public function rules()
    {
        return [
            // 'name' => [
            //     'string',
            //     'required',
            // ],
            // 'price' => [
            //     'required',
            // ],
            // 'description' => [
            //     'string',
            //     'required',
            // ],
        ];
    }
}
