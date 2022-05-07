<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayment;
use App\Models\Versement;
use Auth;

class PaymentController extends Controller
{
    /**
     * Return all payments of all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // return prescriptions created by the auth user
        return response()->json(Versement::with('createdTo', 'validatedPaymentBy')->get());
    }
    /**
     * Return all payments of all users of today
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOfToday()
    {

        return response()->json(Versement::with('createdTo', 'validatedPaymentBy')->where('paid_at',  date('Y-m-d'))->get());
    }
    /**
     * Return all payments by user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUser($id)
    {
        // return prescriptions created by the auth user
        return response()->json(Versement::with('createdTo', 'validatedPaymentBy')->where('paid_by', $id)->get());
    }
    /**
     * Return all the payments of today by user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUserOfToday($id)
    {
        // return prescriptions creatded by the auth user
        return response()->json(Versement::with('createdTo', 'validatedPaymentBy')->where('paid_at',  date('Y-m-d'))->where('paid_by', $id)->get());
    }
    /**
     * Store the new ressource
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $versement = Versement::create($request->all());

        return response()->json(Versement::with('createdTo', 'validatedPaymentBy')->where('id', $versement->id)->get());
    }
    /**
     * store the new payment by patient
     *
     * @param Request $req
     * @param [type] $id Patient ID
     * @return void
     */
    public function storeByPatient(StorePayment $req)
    {
        $versement = Versement::create($req->all() + ['paid_by' => Auth::id()]);
        return response()->json($versement, 201);
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
    public function update(StorePayment $request, $id)
    {
        $versement = Versement::find($id);
        $versement->update($request->except(['_method']));

        $versments = \App\Models\VersementsLog::create([
            'updated_by' => Auth::id(),
            'updated_at' => now(),
            'versement_id' => $id
        ]);

        return response()->json($versement, 200);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function destroy(Versement $payment)
    {
        return $payment->delete() ? response()->json(['success' => 'Règlement supprimée avec succés!'], 200) : 'Erreur dans la suppression';
    }
}
