<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PeliculaRequest extends FormRequest
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
        $maxAnio=date('Y');
        return [
            'titulo'=>'required|string|max:30',
            'duracion'=>'required|integer|min:50|max:500',
            'anio'=>'required|integer|min:1970|max:'.$maxAnio,
            'imagen'=>'nullable|file|mimes:jpeg,png,jpg,JPG|dimensions:min_width=400,min_height=400,max_width=2000,max_height=2000|max:2048',
            'idGenero' => 'nullable|array',
            'idActor' => 'nullable|array'
        ];
    }
}

