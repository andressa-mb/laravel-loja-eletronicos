<?php

namespace App\Http\Requests\UserData;

use Illuminate\Foundation\Http\FormRequest;

class UserDataStoreRequest extends FormRequest
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
            'fullname' => 'required|min:2|max:150',
            'email' => 'required|email|max:100',
            'zipcode' => 'required|max:10',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'street' => 'required|string|max:70',
            'number' => 'required|integer',
            'additional' => 'required|string|max:20',
            'district' => 'required|string|max:50',
            'payment' => 'required|string|max:20',
        ];
    }

/*     public function messages()
    {
        return [
            'fullname.required' => 'Nome do destinatário é obrigatório',
            'fullname.min' => 'O nome do destinatário deve conter mais de 2 caracteres.',
            'fullname.max' => 'O nome do destinatário deve conter até 150 caracteres.',
            'email.required' => 'E-mail é obrigatório',
            'email.max' => 'O e-mail deve conter até 100 caracteres.',
            'zipcode.required' => 'CEP é obrigatório',
            'zipcode.max' => 'O CEP deve conter até 10 caracteres.',
            'city.required' => 'A cidade é obrigatório.',
            'city.max' => 'A cidade deve conter até 50 caracteres.',
            'state.required' => 'O estado é obrigatório.',
            'state.max' => 'O estado deve conter até 2 caracteres.',
            'street.required' => 'A rua é obrigatório.',
            'street.max' => 'A rua deve conter até 70 caracteres.',
            'number.required' => 'O número do local é obrigatório.',
            'number.numeric' => 'Deve ser numérico.',
            'additional.required' => 'O complemento é obrigatório.',
            'additional.max' => 'O complemento deve conter até 20 caracteres.',
            'district.required' => 'O bairro é obrigatório.',
            'district.max' => 'O bairro deve conter até 50 caracteres.',
            'payment.required' => 'A forma de pagamento é obrigatório.',
            'payment.max' => 'A forma de pagamento deve conter até 20 caracteres.',
        ];
    } */
}
