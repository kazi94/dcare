<?php

namespace App\Repository;

use App\Models\Devis;

class QuotationRepo
{
    /**
     * Create a new quotation
     *
     * @param object $data
     * @return \App\Models\Devis
     */
    public function create($data)
    {
        return
            Devis::create($data);
    }
    /**
     * Return Quotation Model by ID
     *
     * @param int $id
     * @return \App\Models\Devis
     */
    public function getByID($id)
    {
        return Devis::findOrFail($id);
    }
    /**
     * Create or Update an existing plan
     * 
     * @param object $data
     * @return \App\Models\Devis
     */
    public function createOrUpdatePlan($data)
    {
        $devis = Devis::updateOrCreate(
            ['patient_id' => $data->patient_id, 'state' => 'plan'],
            [
                'state' => 'plan',
                'total' => $data->total,
                'total_accept' => $data->total_accept,
                'patient_id' => $data->patient_id
            ]
        );
        return $devis;
    }
    /**
     * Create or add new lines to the existing quotation
     *
     * @param \App\Models\Devis $quot
     * @param array $lines
     * @return \App\Models\Devis
     */
    public function createOrPopulateLines($quot, $lines)
    {
        foreach ($lines as $line) {
            $quot->lines()->create($line);
        }
    }
    /**
     * Create lines of the given quotation
     *
     * @param \App\Models\Devis $quotation
     * @param array $lines
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createLines($quotation, $lines)
    {
        return $quotation->lines()->createMany($lines);
    }
    /**
     * delete quotation
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        return Devis::where('id', $id)->delete();
    }
}
