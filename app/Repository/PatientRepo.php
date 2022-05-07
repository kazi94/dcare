<?php

namespace App\Repository;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientRepo
{
    public function __construct()
    {
    }
    public function all()
    {
        return
            Patient::select('id', 'nom', 'prenom', 'age', 'adresse', 'num_tel')->get();
        // Patient::all();
    }

    public function paginate($filter)
    {
        if ($filter->sortBy)
            return Patient::orderBy($filter->sortBy, $filter->sortDesc == 'true' ? 'desc' : 'asc')
                ->paginate($filter->size);

        return Patient::paginate($filter->size);
    }
    /**
     * Return the list of patients with total payments
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function getAllWithStateOfPayment()
    {
        return Patient::with('totalPaid', 'plan.totalDone')->get();
    }
    /**
     * Return list of patients with total payments by name
     *
     * @param string $name
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function getAllWithStateOfPaymentByName($name)
    {
        return Patient::with('totalPaid', 'plan.totalDone')
            ->where('nom', 'like', '%' . $name . '%')
            ->orWhere('prenom', 'like', '%' . $name . '%')
            ->limit(10)
            ->get();
    }
    /**
     * Create new Patient
     *
     * @param object $data
     * @return \App\Models\Patient
     */
    public function create($data)
    {
        $patient                      = new Patient;
        $patient->nom                 = $data->nom;
        $patient->prenom              = $data->prenom;
        $patient->date_naissance      = $data->date_naissance;
        $patient->age                 = $data->date_naissance ? intval(date('Y/m/d', strtotime("now"))) - intval(date('Y/m/d', strtotime($patient->date_naissance))) : '0';
        $patient->profession          = $data->profession;
        $patient->adresse             = $data->adresse;
        $patient->motif               = $data->motif;
        $patient->num_tel             = $data->num_tel;
        $patient->motivation             = $data->motivation;
        $patient->sexe                = $data->sexe;
        $patient->fumeur              = $data->fumeur;
        $patient->medecin_externe     = $data->medecin_externe;
        $patient->created_by          = Auth::id();
        $patient->save();
        return $patient;
    }
    /**
     * get Patient Object with all dependencies
     *
     * @param [type] $id
     * @return Patient $patient
     */
    public function getByIdWith($id)
    {
        return Patient::with(
            'totalPaid',
            'hasPlan',
            'initialSchema.traitements',
            'appointements.assignedTo',
            'appointements.category',
            'appointementsHistory.category',
            'appointementsHistory.assignedTo',
            'antecedents',
            'pathologies',
            'prescriptions',
            'plan.lines.act.coords',
            'plan.lines.act.videos',
            'plan.totalDone',
            'quotations.lines.act.coords',
            'quotations.lineAccepted',
            'quotations.lines.act.videos',
            'payments',
            'radios',
            'memo'
        )->find($id);
    }
    public function syncWithPathologies($patient, $data)
    {
        $patient->pathologies()->sync($data);
    }
    public function syncWithAntecedents($patient, $data)
    {
        $patient->antecedents()->sync($data);
    }

    public function update($id, $data)
    {
        $patient = Patient::find($id);
        $patient->nom                 = ucfirst($data->nom);
        $patient->prenom              = ucfirst($data->prenom);
        $patient->date_naissance      = $data->date_naissance;
        $patient->age                 = $data->date_naissance ? intval(date('Y/m/d', strtotime("now"))) - intval(date('Y/m/d', strtotime($patient->date_naissance))) : '0';
        $patient->profession          = $data->profession;
        $patient->adresse             = $data->adresse;
        $patient->num_tel             = $data->num_tel;
        $patient->sexe                = $data->sexe;
        $patient->fumeur              = $data->fumeur;
        $patient->motivation          = $data->motivation;
        $patient->medecin_externe     = $data->medecin_externe;
        $patient->updated_by          = $data->user()->id;
        $patient->updated_at          = now();
        $patient->save();

        return $patient;
    }
    /**
     * Return Quotation Model by ID
     *
     * @param int $id
     * @return \App\Models\Patient
     */
    public function getByID($id)
    {
        return Patient::findOrFail($id);
    }
    /**
     * delete patient
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        return Patient::where('id', $id)->delete();
    }
    /**
     * Count the number of patients by the date of creation
     *
     * @param date $date
     * @return int
     */
    public function countByCreatedDate($date)
    {
        return Patient::whenDateOfCreation($date)->count();
    }

    /**
     * Get Number of patients group by age range
     *
     * @param string|array $period range of two dates
     * @return App\Models\Patient
     */
    public function groupByAge($period)
    {
        if ($period == 'current-month')
            return
                Patient::select(\DB::raw('concat(10*floor(age/10), \'-\', 10*floor(age/10) + 9, " ans") as `range`'), \DB::raw('count(id) as nbr'))
                ->whereDate("created_at", "<=", \Carbon\Carbon::today()->toDateString())
                ->whereDate("created_at", ">=", \Carbon\Carbon::now()->startOfMonth())
                ->groupBy("range")
                ->get();
        return
            Patient::select(\DB::raw('concat(10*floor(age/10), \'-\', 10*floor(age/10) + 9, " ans") as `range`'), \DB::raw('count(*) as nbr'))
            ->whereDate("created_at", ">=", $period[0])
            ->whereDate("created_at", "<=", $period[1])
            ->groupBy("range")
            ->get();
    }
    /**
     * Get Number of patients group by acts
     *
     * @param string|array $period range of two dates
     * @return App\Models\Patient
     */
    public function groupByActs($period)
    {
        if ($period == 'current-month')
            return
                Patient::select('sexe', \DB::raw('count(id) as nbr'))
                ->whereDate("created_at", "<=", \Carbon\Carbon::today()->toDateString())
                ->whereDate("created_at", ">=", \Carbon\Carbon::now()->startOfMonth())
                ->groupBy("sexe")
                ->get();
        return
            Patient::select('sexe', \DB::raw('count(*) as nbr'))
            ->whereDate("created_at", ">=", $period[0])
            ->whereDate("created_at", "<=", $period[1])
            ->groupBy("sexe")
            ->get();
    }
    /**
     * Get Number of patients group by motivation
     *
     * @param string|array $period range of two dates
     * @return App\Models\Patient
     */
    public function groupByMotivations($period)
    {
        if ($period == 'current-month')
            return
                Patient::select('motivation', \DB::raw('count(id) as nbr'))
                ->whereDate("created_at", "<=", \Carbon\Carbon::today()->toDateString())
                // ->whereDate("created_at", ">=", \Carbon\Carbon::now()->startOfMonth()->subMonth()->toDateString())
                ->whereDate("created_at", ">=", \Carbon\Carbon::now()->startOfMonth())
                ->whereNotNull('motivation')
                ->groupBy("motivation")
                ->get();
        return
            Patient::select('motivation', \DB::raw('count(*) as nbr'))
            ->whereDate("created_at", ">=", $period[0])
            ->whereDate("created_at", "<=", $period[1])
            ->whereNotNull('motivation')
            ->groupBy("motivation")
            ->get();
    }
    /**
     * Get Number of patients group by categories
     *
     * @param string|array $period range of two dates
     * @return App\Models\Patient
     */
    public function groupByCategories($period)
    {
        if ($period == 'current-month')
            return
                Patient::select('sexe', \DB::raw('count(id) as nbr'))
                ->whereDate("created_at", "<=", \Carbon\Carbon::today()->toDateString())
                ->whereDate("created_at", ">=", \Carbon\Carbon::now()->startOfMonth())
                ->groupBy("sexe")
                ->get();
        return
            Patient::select('sexe', \DB::raw('count(*) as nbr'))
            ->whereDate("created_at", ">=", $period[0])
            ->whereDate("created_at", "<=", $period[1])
            ->groupBy("sexe")
            ->get();
    }
    /**
     * Get Number of patients group by sexe
     *
     * @param string|array $period range of two dates
     * @return App\Models\Patient
     */
    public function groupBySexe($period)
    {
        if ($period == 'current-month')
            return
                Patient::select('sexe', \DB::raw('count(id) as nbr'))
                ->whereDate("created_at", "<=", \Carbon\Carbon::today()->toDateString())
                ->whereDate("created_at", ">=", \Carbon\Carbon::now()->startOfMonth())
                ->groupBy("sexe")
                ->get();
        return
            Patient::select('sexe', \DB::raw('count(*) as nbr'))
            ->whereDate("created_at", ">=", $period[0])
            ->whereDate("created_at", "<=", $period[1])
            ->groupBy("sexe")
            ->get();
    }
    public function getPatientsByName($name)
    {
        return Patient::where('nom', 'like', '%' . $name . '%')
            ->orWhere('prenom', 'like', '%' . $name . '%')
            ->limit(20)
            ->get();
    }

    public function getAllWithDebt()
    {
        return Patient::with('totalPaid', 'plan.totalDone')->get();
    }
    public function getAllWithDebts()
    {
        return Patient::with('totalPaids', 'plan.totalDone')->get();
    }
}
