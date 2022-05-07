<?php

namespace App\Repository;

use App\Models\Prescription;

class PrescriptionRepo
{
    /**
     * Count the number of prescriptions by the date of creation
     *
     * @param date t$date
     * @return int
     */
    public function countByCreatedDate($date)
    {
        return Prescription::whereDate('created_at', $date)->count();
    }
}
