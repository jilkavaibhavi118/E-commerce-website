<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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
        if (!empty(request('id'))) {
            $rule['name'] = 'required|unique:roles,name,' . request('id');
        } else {
            $rule['name'] = 'required|unique:roles';
        }
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter role name',
            'name.unique' => 'Role name has already been taken'
        ];
    }
}
