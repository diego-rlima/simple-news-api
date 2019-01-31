<?php

namespace App\Units\Posts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
        return [
            'name' => 'required|min:3|max:191',
            'slug' => 'required|min:3|unique:categories,slug',
        ];
    }

    /**
     * Get the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Você precisa informar um nome',
            'name.min' => 'O nome precisa ter no mínimo 3 caracteres',
            'name.max' => 'O nome precisa ter no máximo 191 caracteres',
            'slug.required' => 'Você precisa informar um slug',
            'slug.min' => 'O slug precisa ter no mínimo 3 caracteres',
        ];
    }
}
