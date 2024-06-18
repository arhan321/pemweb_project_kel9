<?php

namespace App\Http\Requests;

use Gate;
use App\Models\Testimonial;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('testimonial_create');
    }

    public function rules()
    {
        return [
            // 'name' => [
            //     'string',
            //     'required',
            // ],
            // 'description' => [
            //     'string',
            //     'nullable',
            // ],
            // 'start' => [
            //     'date_format:' . config('panel.time_format'),
            //     'nullable',
            // ],
            // 'finish' => [
            //     'date_format:' . config('panel.time_format'),
            //     'nullable',
            // ],
        ];
    }
}
