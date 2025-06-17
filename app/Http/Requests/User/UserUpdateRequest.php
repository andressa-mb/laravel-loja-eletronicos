<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|min:2|max:150',
            'email' => 'required|email|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome do usuário é obrigatório',
            'name.min' => 'O nome deve conter mais de 2 caracteres.',
            'name.max' => 'O nome deve conter até 150 caracteres.',
            'email.required' => 'Nome do usuário é obrigatório',
            'email.max' => 'O email deve conter até 100 caracteres.',
        ];
    }
}
