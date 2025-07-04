<?php

namespace App\Http\Requests\Discounts;

use Illuminate\Foundation\Http\FormRequest;

class DiscountUpdateRequest extends FormRequest
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
            'typeDiscount' => 'required|in:%,R$',
            'percentDiscount' => 'required_if:typeDiscount,%|numeric|between:5,30',
            'valueDiscount' => 'required_if:typeDiscount,R$|numeric|min:0.01',
            'startDate' => 'required|date|after:today',
            'endDate' => 'date|after:start_date',
            'messageDiscount' => 'string|min:3|max:150',
        ];
    }

    public function messages()
    {
        return [
            'typeDiscount.required' => 'O tipo é obrigatório.',
            'typeDiscount.in' => 'O tipo deve ser % ou R$.',
            'percentDiscount.required_if' => 'O percentual é obrigatório para desconto percentual.',
            'percentDiscount.between' => 'O percentual deve estar entre 5% e 30%.',
            'valueDiscount.required_if' => 'O valor é obrigatório para desconto em reais.',
            'valueDiscount.min' => 'O valor mínimo é R$ 0,01.',
            'startDate.required' => 'A data inicial é obrigatória.',
            'startDate.date' => 'A data inicial deve ser uma data atual.',
            'startDate.after' => 'A data inicial deve ser após a data atual.',
            'endDate.date' => 'A data final deve ser válida.',
            'endDate.after' => 'A data final deve ser após a data inicial.',
            'messageDiscount.string' => 'A mensagem deve ser texto.',
            'messageDiscount.min' => 'A mensagem deve ter no mínimo 3 caracteres.',
            'messageDiscount.max' => 'A mensagem deve ter no máximo 150 caracteres.',
        ];
    }
}
