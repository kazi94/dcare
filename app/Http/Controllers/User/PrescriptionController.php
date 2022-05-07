<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Requests\StorePatient;
use Illuminate\Database\Query\Builder;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Ligneprescription;
use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('prescriptions.show');
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
     * store request fields
     *
     * @return view
     * @author
     **/
    public function store(Request $request)
    {
        $prescription = new Prescription;
        $prescription->medicaments = $request->medicaments;
        $prescription->date_prescription = today();
        $prescription->patient_id = $request->patient_id;
        $prescription->created_by = Auth::id();
        $prescription->save();

        // $this->addLignesPrescription($prescription->id, $request->medicaments);

        return response()->json([
            'prescription' => $prescription->load('prescribedTo'),
            'success' => 'Prescription ajoutée avec succés!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return Prescription::with('lignes')->find($id);
    }

    /**
     * Show the patient profile , and his folder :
     * auto , traitement , medical , biological analysis , phyto  *...etc
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
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
        Ligneprescription::where('prescription_id', $id)->delete();

        return
            $this->addLignesPrescription($id, $request->medicaments) ?
            response()->json(['success' => 'Prescription modifiée avec succés!'], 200) : 'Erreur dans la modification';
    }

    /**
     * delete Prescription function
     *
     * @return void
     * @author
     **/
    public function destroy($id)
    {
        $deleted = Prescription::where('id', $id)->delete();

        return $deleted ?  response()->json(['success' => 'Prescription supprimée avec succés!'], 200) : 'Erreur dans la suppression';
    }

    /**
     * print prescription
     *
     * @return void
     * @author
     **/
    public function print($id)
    {
        $prescription = Prescription::with('lignes', 'patient', 'user.cabinet')->find($id);

        return view('patient.reports.prescription_report', compact('prescription'));
    }

    /**
     * Add lignes Prescriptions
     *
     * @return void
     * @author
     **/
    private function addLignesPrescription($id, $lignes)
    {
        foreach ($lignes as $val) {
            $ligne = new Ligneprescription;
            $ligne->medicament = $val;
            $ligne->prescription_id = $id;
            $ligne->save();
        }

        return true;
    }
}
