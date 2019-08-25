<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* return \Gate::authorize('update', $this->route('role')); */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){

        //sino es post le agrego
        if($this->method() === 'POST') {

            $rules = [
                'name' => 'required|unique:roles',
                'display_name'=>'required'           
            ];
            
        }else if ($this->method() === 'PUT'){

            $rules = [
                'display_name'=>'required'           
            ];
        }
        
        return $rules;
    }
    public  function messages()
    {
        return [
            'display_name.required'=>'El nombre es obligatorio',
            'name.required'=>'El identificador es obligatorio',
            'name.unique'=>'Este identificador ya ha sido registrado',
        ];
    }
}
