<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            "matricule"  => "max:50",
            "name"       => "required|string|unique:users|max:60",
            "prenom"     => "required|string|unique:users|max:60",
            "role_id"    => "required",
            "email"      => "required|email|string|unique:users",
            "password"   => "required|min:6|string"
        ];
    }
           /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => "Le champ :attribute est obligatoire"         ,
            'max'      => "Le champ :attribute maximum :max alphabets"  ,
            'min'      => "Le champ :attribute minimum :min caractères" ,
            'unique'   => "Le champ :attribute est déja pris"           ,
            'email'    => "Le champ :attribute doit ètre de type email ",
        ];
    }
}
