<?php

namespace App\Units\Posts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyPostRequest extends FormRequest
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
        ];
    }
}
