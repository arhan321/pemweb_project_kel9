<?php

namespace App\Http\Requests;

use Gate;
use App\Models\Testimonial;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('testimonial_edit');
    }

    public function rules()
    {
        return [
         
        ];
    }
}
