<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    public function lignes()
    {
        return $this->hasMany('App\Models\Ligneprescription');
    }

    public function prescribedTo()
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    /**
     * return user whom update the prescription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    /**
     * Get prescription date
     *
     * @param  string  $value
     * @return string
     */
    public function getDatePrescriptionAttribute($value)
    {
        $tims = explode(' ', $this->created_at);
        $date = $tims[0];
        return $date;
    }
}
