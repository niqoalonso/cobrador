<?php

namespace App\Http\Requests\Administracion\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'        => [($this->method() == 'PUT') ? Rule::unique('roles', 'name')->ignore($this->id, 'id') : 'unique:roles,name', 'max:100'],
        ];
    }

    public function messages()
    {   
        return [
            'nombre.required'       =>  'Nombre es requerido.',
            'nombre.unique'         =>  'ROL ya ingresado.',
            'nombre.max'            =>  'Nombre no puede exceder los 100 caracteres.',
        ];
    }

}
