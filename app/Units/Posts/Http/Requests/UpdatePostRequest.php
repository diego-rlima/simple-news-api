<?php

namespace App\Units\Posts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|min:3|max:191',
            'slug' => 'required|min:3|unique:posts,slug,' . decode_id($this->route('id')),
            'content' => 'required',
            'categories' => 'nullable|array',
            'thumbnail' => 'nullable|image',
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
            'title.required' => 'Você precisa informar um título',
            'title.min' => 'O título precisa ter no mínimo 3 caracteres',
            'title.max' => 'O título precisa ter no máximo 191 caracteres',
            'slug.required' => 'Você precisa informar um slug',
            'slug.min' => 'O slug precisa ter no mínimo 3 caracteres',
            'content.required' => 'Você precisa informar um conteúdo',
            'categories.array' => 'Você precisa uma lista de categorias',
            'thumbnail.image' => 'O thumbnail precisa ser uma imagem válida',
        ];
    }
}
