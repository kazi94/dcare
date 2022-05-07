<?php

namespace App\Repository;

use App\Models\Versement;

class PaymentRepo
{
    public function getTotalPaymentsByCreatedDate($date)
    {
        return Versement::where('paid_at', $date)
            ->groupBy('paid_at')
            ->select(
                \DB::raw("SUM(total_paid) as total"),

            )->first();
    }
    /**
     * Calculate total of payments for the current month
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function countPaymentsOfTheCurrentMonth()
    {
        return Versement::where(\DB::raw("CAST(paid_at AS DATE)"), "<=", \Carbon\Carbon::today()->toDateString())
            ->where(\DB::raw("CAST(paid_at AS DATE)"), ">=", \Carbon\Carbon::now()->startOfMonth()->toDateString())
            ->groupBy('month')
            ->select(
                \DB::raw("SUM(total_paid) as amount"),
                \DB::raw(" MONTHNAME(paid_at) as month")
            )->get();
    }
    /**
     * Calculate total of payments by month
     * between a range of period
     * @param array $period
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function countPaymentsBetweenPeriode($period)
    {
        return Versement::whereBetween(\DB::raw("CAST(paid_at AS DATE)"), $period)
            ->groupBy('month')
            ->select(
                \DB::raw("SUM(total_paid) as amount"),
                \DB::raw(" MONTHNAME(paid_at) as month")
            )->get();
    }
}
