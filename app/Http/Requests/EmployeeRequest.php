<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'nip' => 'required |numeric',
            'employee_name' => 'required|alpha',
            'gender'=> 'required',
            'job_section'=>'required|max:50|alpha',
<<<<<<< HEAD
            'phone'=>'required |numeric',
=======
            'phone'=>'required|regex:/^(08)[0-9]{8,11}$/|numeric',
>>>>>>> 87c2c0cd19d83e010c2dbe16076ef165e08af4ea
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
