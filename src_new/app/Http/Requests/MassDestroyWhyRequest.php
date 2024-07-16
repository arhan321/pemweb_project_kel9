<?php

namespace App\Http\Requests;

use Gate;
use App\Models\Why;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGalleryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('why_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whies,id',
        ];
    }
}
