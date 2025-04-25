<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //AQUI VAI COLOCAR QUEM TEM ASUTORIZAÇÃO PARA CRIAR UM PRODUTO
        //**ainda será feito as roles do sistema
        //https://laravel.com/docs/7.x/validation#creating-form-requests
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
            'name' => 'required|min:2|max:25',
            'description' => 'max:100|nullable',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome do produto é obrigatório',
            'name.min' => 'O nome do produto deve conter mais de 2 caracteres.',
            'name.max' => 'O nome do produto deve conter até 25 caracteres.',
            'description.max' => 'A descrição deve conter até 100 caracteres.',
            'price.required' => 'O valor do produto é obrigatório.',
            'price.numeric' => 'O valor do produto deve ser numérico.',
            'quantity.required' => 'A quantidade do produto é obrigatório.',
            'quantity.numeric' => 'A quantidade do produto deve ser numérico.',
            'discount.numeric' => 'O desconto deve ser numérico.',
            'image.mimes' => 'O arquivo de imagem deve ser nos formatos: png, jpg ou jpeg.',
        ];
    }
}
