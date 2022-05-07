<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Versement;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('payments.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json();
    }

    /**
     * store request fields
     *
     * @return \Illuminate\Http\JsonResponse
     * @author
     **/
    public function store(Request $request)
    {
        $versement = Versement::create($request->all());

        return response()->json(Versement::with('createdTo', 'validatedPaymentBy')->where('id', $versement->id)->get());
    }

    public function storeByPatient(Request $request, $id)
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
     * delete Prescription function
     *
     * @return void
     * @author
     **/
    public function destroy($id)
    {
    }
}
