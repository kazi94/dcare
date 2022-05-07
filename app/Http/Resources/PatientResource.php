<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $debtor = null;
        if (isset($this->plan) && isset($this->plan->totalDone))
            $debtor = (!is_null($this->totalPaid) ? (int)$this->totalPaid->value - (int)$this->plan->totalDone->value : 0 - (int)$this->plan->totalDone->value);

        if ($debtor <= -2000 && $debtor) {
            return [
                'patient' => $this->nom . " " . $this->prenom,
                'num_tel' => $this->num_tel,
                'total_debt' =>  $debtor
            ];
        }
    }
}
