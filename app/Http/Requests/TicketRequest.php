<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('ticketing');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|numeric|regex:/^08[0-9]{8,11}$/',
            'code'  => 'required',
            'date'  => 'required',
            'assignLocation' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'departureTime' => 'required',
            'selectedSeat' => 'required',
            'customer' => 'required',
            'payment_type' => 'required',
            'cash_amount' => 'required_if:payment_type,1|numeric',
            'cash_change' => 'required_if:payment_type,1|numeric',
            'card_type' => 'required_if:payment_type,0',
            'bank_name' => 'required_if:payment_type,0|min:1',
            'no_card'   => 'required_if:payment_type,0|numeric|regex:/^[0-9]{6,16}$/',

        ];
    }
}
