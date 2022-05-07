<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatient;
use App\Http\Resources\PatientResource;
use Illuminate\Database\Query\Builder;
use App\Models\Patient;
use App\Models\Pathologie;
use App\Models\Antecedent;
use App\Repository\PatientRepo;
use Auth;
use Storage;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public $patient;

    public function __construct(PatientRepo $patientRepo)
    {
        $this->patient = $patientRepo;
    }

    public function index(Request $req)
    {

        $patients = $this->patient->all();

        return response()->json($patients);
    }

    public function getAllWithTotalPaid()
    {
        return response()->json($this->patient->getAllWithStateOfPayment());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
    }
    /**
     * Summary of store
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatient $request)
    {
        //* CREATE NEW PATIENT
        $patient = $this->patient->create($request);

        //* ASSOCIATION PATIENT WITH PATHOLOGIES
        $this->patient->syncWithPathologies($patient, collect($request->pathologies)->map->id);

        //* ASSOCIATE PATIENT WITH ANTECEDENTS
        $this->patient->syncWithAntecedents($patient, collect($request->antecedents)->map->id);

        return response()->json($patient, 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
    }
    protected function getPathologies()
    {
        return DB::table('pathologies')->get();
    }
    protected function getAntecedents()
    {
        return DB::table('antecedents')->get();
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $patient = $this->patient->getByIdWith($id);

        return response()->json([
            'patient' => $patient,
            // 'pathologies' => $pats,
            // 'antecedents' => $ant
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @author __KaziWhite**__SALAF4_WebDev**.
     */
    public function update(Request $request, $id)
    {
        //* UPDATE PATIENT
        $patient = $this->patient->update($id, $request);

        //* ASSOCIATION PATIENT WITH PATHOLOGIES
        $this->patient->syncWithPathologies($patient, collect($request->pathologies)->map->id);

        //* ASSOCIATE PATIENT WITH ANTECEDENTS
        $this->patient->syncWithAntecedents($patient, collect($request->antecedents)->map->id);

        return response()->json([
            'patient' => $patient->load('pathologies', 'antecedents'),
            'success' => 'Patient modifier avec succés!'
        ]);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function destroy($id)
    {
        $deleted =  Patient::where('id', $id)->delete();

        return $deleted ?  response()->json(['success' => 'Patient supprimé avec succés!'], 200) : 'Erreur dans la suppression';
    }


    /**
     * Return to the client list of created patients by date range
     *
     * @param [Date] $start
     * @param [Date] $end
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBetweenTwoDates($start = null, $end = null)
    {
        if (isset($start) && isset($end)) {
            $results = Patient::select(DB::raw("cast(created_at as date) as date_created"), DB::raw('count(id) as nbr'))
                ->whereBetween(DB::raw("cast(created_at as date)"), [$start, $end])
                ->groupBy("date_created")
                ->get();
        } else {
            $results = Patient::select(DB::raw("cast(created_at as date) as date_created"), DB::raw('count(id) as nbr'))
                ->groupBy("date_created")
                ->get();
        }
        return Response()->json($results);
    }

    public function searchPatient($input)
    {
        return response()->json($this->patient->getPatientsByName($input), 200);
    }
    /**
     * Return the list of search patient and the total of payments
     *
     * @param [type] $input
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function getTotalPaidOfSearchedPatient($input)
    {
        return response()->json($this->patient->getAllWithStateOfPaymentByName($input), 200);
    }
    /**
     * Return Patients with debtor
     *
     * @return void
     */
    public function getWithDebt()
    {
        $totalDebt = 0;
        $patientsInDebt = $this->patient->getAllWithDebts();
        $patientsInDebt = $patientsInDebt->map(function ($patient) use ($totalDebt) {
            $debtor = null;
            if (isset($patient->plan) && isset($patient->plan->totalDone)) {
                $debtor = (!is_null($patient->totalPaids) ? (int)$patient->totalPaids->value - (int)$patient->plan->totalDone->value : 0 - (int)$patient->plan->totalDone->value);
            }

            if ($debtor <= -2000 && $debtor) {
                return [
                    'patient' => $patient->nom . " " . $patient->prenom,
                    'num_tel' => $patient->num_tel,
                    'date_debt' => $patient->totalPaids->date_debt,
                    'total_debt' =>  $debtor
                ];
            }
        })->filter()->values()->toArray();
        $totalDebt = collect($patientsInDebt)->sum('total_debt');
        return response()->json([
            'patientsInDebt' => $patientsInDebt,
            'totalDebt' => abs($totalDebt)
        ]);
    }
}
