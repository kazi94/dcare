<?php

namespace App\Http\Controllers\Api;

use App\Repository\LigneDevisRepo;
use App\Repository\PatientRepo;
use App\Repository\PrescriptionRepo;
use App\Repository\AppointementRepo;
use App\Repository\PaymentRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StringTrait;

class DashboardController extends Controller
{
    use StringTrait;

    public $patients;
    public $prescriptions;
    public $lignesDevis;
    public $appointements;
    public $payments;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PatientRepo $patientRepo, LigneDevisRepo $ligneDevisRepo, AppointementRepo $appointementRepo, PrescriptionRepo $prescriptionRepo, PaymentRepo $paymentsRepo)
    {
        $this->middleware('auth');
        $this->appointements = $appointementRepo;
        $this->patients = $patientRepo;
        $this->lignesDevis = $ligneDevisRepo;
        $this->prescriptions = $prescriptionRepo;
        $this->payments = $paymentsRepo;
    }
    /**
     * Return Daily data to the client
     *
     * @return void
     */
    public function getDailyData()
    {
        $today = date('Y-m-d');
        $patientsNumber = $this->patients->countByCreatedDate($today);
        $actesNumber = $this->lignesDevis->countByCreatedDate($today);
        $prescriptionsNumber =  $this->prescriptions->countByCreatedDate($today);
        $totalPayments = $this->payments->getTotalPaymentsByCreatedDate($today);


        return response()->json([
            "patientsNumber" => $patientsNumber,
            "actesNumber" => $actesNumber,
            "prescriptionsNumber" => $prescriptionsNumber,
            "totalPayments" => $totalPayments,

        ]);
    }
    /**
     * Return List of Appointements of today
     *
     * @return void
     */
    public function getToDayAppointements()
    {
        $today = date('Y-m-d');

        $toDayAppointements = $this->appointements->getByStartedDate($today);

        $waitingPatientsOfToday = $this->appointements->getWaitingPatientsOf($today);

        return response()->json(
            [
                "toDayAppointements" => $toDayAppointements,
                "waitingPatientsOfToday" => $waitingPatientsOfToday
            ],
            200
        );
    }

    public function getPatientsByAge($period = "current-month")
    {
        if ($period == "current-month")
            $patients = $this->patients->groupByAge($period);
        else
            $patients = $this->patients->groupByAge($this->splitToArray($period));

        return response()->json(['patients' => $patients], 200);
    }
    /**
     * Return Number of patients grouped by sex
     *
     * @param string $period
     * @return void
     */
    public function getPatientsBySexe($period = "current-month")
    {
        if ($period == "current-month")
            $patients = $this->patients->groupBySexe($period);
        else
            $patients = $this->patients->groupBySexe($this->splitToArray($period));

        return response()->json(['patients' => $patients], 200);
    }
    /**
     * Return Number of patients grouped by categories
     *
     * @param string $period
     * @return void
     */
    public function getPatientsByCategories($period = "current-month")
    {
        if ($period == "current-month")
            $patients = $this->patients->groupByCategories($period);
        else
            $patients = $this->patients->groupByCategories($this->splitToArray($period));

        return response()->json(['patients' => $patients], 200);
    }
    /**
     * Return Number of patients grouped by motivations
     *
     * @param string $period
     * @return void
     */
    public function getPatientsByMotivations($period = "current-month")
    {
        if ($period == "current-month")
            $patients = $this->patients->groupByMotivations($period);
        else
            $patients = $this->patients->groupByMotivations($this->splitToArray($period));

        return response()->json(['patients' => $patients], 200);
    }
    /**
     * Return Number of patients grouped by acts
     *
     * @param string $period
     * @return void
     */
    public function getPatientsByActs($period = "current-month")
    {
        if ($period == "current-month")
            $patients = $this->patients->groupByActs($period);
        else
            $patients = $this->patients->groupByActs($this->splitToArray($period));

        return response()->json(['patients' => $patients], 200);
    }
    /**
     * Return Number of acts grouped by time interval
     *
     * @param string $period
     * @return void
     */
    public function getActsByTime($period = "current-month")
    {
        if ($period == "current-month")
            $acts = $this->lignesDevis->countActsGroupByUpdatedDateForCurrentMonth(
                "fait"
            );
        else
            $acts = $this->lignesDevis->countActsGroupByUpdatedDate("fait", $this->splitToArray($period));

        return response()->json(['acts' => $acts], 200);
    }

    public function getActsDone($period = "current-month")
    {
        if ($period == "current-month") {
            $acts = $this->lignesDevis->countActsOfTheCurrentMonthByState("fait");
        } else {
            $acts = $this->lignesDevis->countActsBetweenPeriodByState("fait", $this->splitToArray($period));
        }
        $total = $acts->sum('nbrActs');
        $acts = $acts->map(function ($act) use ($total) {
            return [
                "act" => $act->act->nom,
                "nbrActsDone" => $act->nbrActs,
                "actsDoneRatio" => (int)($act->nbrActs / $total * 100) . "%"
            ];
        });

        return response()->json(['acts' => $acts], 200);
    }

    public function getTotalPaymentsByMonth($period = "current-month")
    {
        if ($period == "current-month") {
            $total = $this->payments->countPaymentsOfTheCurrentMonth();
        } else {
            $total = $this->payments->countPaymentsBetweenPeriode($this->splitToArray($period));
        }

        return response()->json(['total' => $total], 200);
    }
    /**
     * Return the total revenue of acts done per category
     *
     * @param string $period
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function sumTotalActsDoneByCategory($period = "current-month")
    {
        if ($period == "current-month") {
            $total = $this->lignesDevis->sumActsPerCategoryOfTheCurrentMonth("fait");
        } else {
            $total = $this->lignesDevis->sumActsPerCategoryBetweenPeriod("fait", $this->splitToArray($period));
        }

        return response()->json(['total' => $total], 200);
    }
    /**
     * Return the total revenue of acts done
     *
     * @param string $period
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function sumTotalActsDone($period = "current-month")
    {
        if ($period == "current-month") {
            $acts = $this->lignesDevis->sumActsOfTheCurrentMonth("fait");
        } else {
            $acts = $this->lignesDevis->sumActsBetweenPeriod("fait", $this->splitToArray($period));
        }

        return response()->json(['acts' => $acts], 200);
    }

    public function getTotalDebtor()
    {
        $totalDebt = 0;
        $patientsInDebt = $this->patients->getAllWithDebt();
        $patientsInDebt = $patientsInDebt->map(function ($patient) use ($totalDebt) {
            $debtor = null;
            if (isset($patient->plan) && isset($patient->plan->totalDone)) {
                $debtor = (!is_null($patient->totalPaid) ? (int)$patient->totalPaid->value - (int)$patient->plan->totalDone->value : 0 - (int)$patient->plan->totalDone->value);
            }

            if ($debtor <= -2000 && $debtor) {
                return [
                    'patient' => $patient->nom . " " . $patient->prenom,
                    'num_tel' => $patient->num_tel,
                    'total_debt' =>  $debtor
                ];
            }
        })->filter()->values()->toArray();
        $totalDebt = collect($patientsInDebt)->sum('total_debt');
        return response()->json($totalDebt);
    }
}
