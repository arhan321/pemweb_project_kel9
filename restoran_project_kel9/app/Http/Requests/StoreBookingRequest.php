<?php

namespace App\Http\Requests;

use Gate;
use App\Models\Booking;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('booking_create');
    }

    public function rules()
    {
        return [
            // 'start_book' => [
            //     'required',
            //     'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            // ],
            // 'finish_book' => [
            //     'required',
            //     'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            // ],
            // 'category' => [
            //     'required',
            // ],
        ];
    }
}
