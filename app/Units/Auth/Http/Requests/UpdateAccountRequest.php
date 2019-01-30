<?php

namespace App\Units\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|confirmed'
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
            'name.required' => 'Informe um nome',
            'name.min' => 'O nome deve conter no mínimo :min caracteres',
            'name.max' => 'O nome deve conter no máximo :max caracteres',
            'email.required' => 'Informe um email',
            'email.unique' => 'Este email já está em uso',
            'email.email' => 'Informe um email válido',
            'password.confirmed' => 'Você deve confirmar a senha',
        ];
    }
}
