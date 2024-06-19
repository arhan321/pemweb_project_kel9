<?php

namespace App\Http\Requests;

use Gate;
use App\Models\Testimonial;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTestimonialsRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('testimonial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:testimonials,id',
        ];
    }
}
