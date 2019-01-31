<?php

namespace App\Units\Uploads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUploadRequest extends FormRequest
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
            'name' => 'nullable|min:3|max:191',
            'file' => 'required|file',
            'data' => 'nullable|array'
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
            'name.min' => 'O nome precisa ter no mínimo 3 caracteres',
            'name.max' => 'O nome precisa ter no máximo 191 caracteres',
            'file.required' => 'Você precisa enviar um arquivo',
            'file.file' => 'O arquivo enviado não é válido',
            'data.array' => 'As informações do arquivo não são válidas',
        ];
    }
}
