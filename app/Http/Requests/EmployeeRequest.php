<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as Req;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Req $request)
    {
        return [
            'nip' => "required|numeric|regex:/^[0-9]{3,7}$/|unique:employees,nip,$request->id",
            'employee_name' => 'required|alpha',
            'gender'=> 'required',
            'job_section'=>'required|max:50',
            'phone'=>'required|regex:/^(08)[0-9]{8,11}$/|numeric',
            'address'=>'required|max:100',

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
