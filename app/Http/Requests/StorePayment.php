<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayment extends FormRequest
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
                'total_paid' => 'numeric|digits_between:1,9',
                'paid_at' => 'date',
                'patient_id' => 'exists:patients,id|numeric',
            ];
        } else

            return [
                'id' => 'exists:versements,id|numeric',
                'total_paid' => 'numeric|digits_between:1,9',
                'paid_at' => 'date',
                'patient_id' => 'exists:patients,id|numeric',
            ];
    }
}
