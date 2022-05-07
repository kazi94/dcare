<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                "code_cnas" => "nullable|string|max:20",
                "nom" => "required|string|unique:actes",
                "type" => "required|string",
                "shortcut" => "nullable|string|max:7",
                "category" => "exists:categories,id",
                "price" => "required|digits_between:1,6",
                "formes" => "array",
                "formes.*.formulas" => "string",
                "formes.*.color" => "string",
            ];
        } else {
            return [
                "code_cnas" => "nullable|string|max:20",
                "nom" => "required|string",
                "type" => "required|string",
                "shortcut" => "nullable|string|max:7",
                "category" => "exists:categories,id",
                "price" => "required|digits_between:1,6",
                "formes" => "array",
                "formes.*.formulas" => "string",
                "formes.*.color" => "string",
            ];
        }
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'formes.required' => 'La :attribute est obligatoire',
        ];
    }
}
