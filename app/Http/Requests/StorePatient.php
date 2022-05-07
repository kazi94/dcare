<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatient extends FormRequest
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
                "nom"  => "required|string",
                "prenom" => "required|string",
                "sexe"  => "required|string",
                "num_tel"  => "nullable|string",
                "profession"  => "nullable|string",
                "date_naissance"  => "required|date",
                "motif"  => "nullable|string",
                "pathologies" => "array|nullable",
                "antecedents" => "array|nullable",
                "pathologies.*.id" => "exists:pathologies,id",
                "antecedents.*.id" => "exists:antecedents,id",
            ];
        } else {
            return [
                "id"  => "exists:patients,id",
                "prenom" => "required|string",
                "sexe"  => "required|string",
                "num_tel"  => "nullable|string",
                "profession"  => "nullable|string",
                "date_naissance"  => "required|date",
                "motif"  => "nullable|string",
                "pathologies" => "array|nullable",
                "antecedents" => "array|nullable",
                "pathologies.*.id" => "exists:pathologies,id",
                "antecedents.*.id" => "exists:antecedents,id",
            ];
        }
    }
}
