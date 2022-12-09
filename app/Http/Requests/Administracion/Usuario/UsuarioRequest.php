<?php

namespace App\Http\Requests\Administracion\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rut'           =>  [($this->method() == 'PUT') ? Rule::unique('users', 'rut')->ignore($this->id, 'id') : 'unique:users,rut', 'max:10'],
            'nombres'       =>  ['required', 'max:100'],
            'apellidos'     =>  ['required', 'max:100'],
            'correo'        =>  [($this->method() == 'PUT') ? Rule::unique('users', 'email')->ignore($this->id, 'id') : 'unique:users,email', 'email','max:100'],
            'rol'           =>  ['required'],
        ];
    }

    public function messages()
    {
        return [
            'rut.required'          =>  "Debes ingresar un RUT.",
            'rut.unique'            =>  "RUT ya esta ingresado.",
            'nombres.required'      =>  "Nombres es requerido.",
            'nombres.max'           =>  "Nombre no puede exceder los 100 caracteres.",
            'apellidos.required'    =>  "Apellidos es requerido.",
            'apellidos.max'         =>  "Apellido no puede exceder los 100 caracteres.",
            'correo.required'       =>  "Correo electronico es requerido.",
            'correo.email'          =>  "Correo electronico no tiene un formato correcto.",
            'correo.max'            =>  "Correo electronico no puede exceder los 100 caracteres.",
            'correo.unique'         =>  "Correo electronico ya existe registrado.",
            'rol.required'          =>  "Debes seleccionar un ROL.",
        ];
    }
}
