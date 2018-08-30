<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole("admin");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required_without:idUser|string|max:100|min:3|unique:users',
            'email' => 'required_without:idUser|string|email|max:100|unique:users',
            'idRol'=>'required|integer|exists:roles,id',


        ];
    }
}
