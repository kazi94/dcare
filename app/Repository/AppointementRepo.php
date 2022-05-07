<?php

namespace App\Repository;

use App\Models\Appointement;

class AppointementRepo
{
    /**
     * Count the number of appointements by the date of creation
     *
     * @param date $date
     * @return int
     */
    public function getByStartedDate($date)
    {
        return Appointement::whenStartDateIs($date)
            ->whereNull('state')
            ->with('category', 'patient', 'assignedTo')
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function getWaitingPatientsOf($date)
    {
        return Appointement::whenStartDateIs($date)
            ->where('state', 'validate')
            ->with('category', 'patient', 'assignedTo')
            ->get();
    }
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */

    public function getByIdWithRelations($id)
    {
        return Appointement::with('category', 'patient', 'assignedTo')->where('id', $id)->first();
    }
    /**
     * get the list of upcomming appointements from to day
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return object
     *
     */

    public function getUpcoming()
    {
        return Appointement::whereDate('start_date', '>=', date('Y-m-d'))->get();
    }
}
