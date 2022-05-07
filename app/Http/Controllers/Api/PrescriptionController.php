<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Auth;

class PrescriptionController extends Controller
{
    /**
     * return prescriptions created by the auth User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Prescription::with('prescribedTo', 'updatedBy')->whereCreatedBy(Auth::user()->id)->get(), 200);
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
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function destroy(Prescription $prescription)
    {
        return $prescription->delete() ? response()->json(['success' => 'Prescription supprimée avec succés!'], 200) : 'Erreur dans la suppression';
    }
}
