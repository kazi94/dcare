<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Requests\StorePatient;
use Illuminate\Database\Query\Builder;
use App\Models\Patient;
use DB;
use Auth;

class ActeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.acte.show'/*,compact('acte')*/);
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
     * @return view
     * @author
     **/
    public function store(Request $request)
    {
        // return redirect(route('acte.edit' , '1'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json();
    }

    /**
     * Show the acte profile , and his folder :
     * auto , traitement , medical , biological analysis , phyto  *...etc
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @author __KaziWhite**__SALAF4_WebDev**.
     */
    // public function update(Storeacte $request, $id)

    // {

    //     return redirect(route('acte.edit',$acte->id))->with('message' , 'Profile acte modifié avec succés !'); //or to back back()->withInput();
    // }
}
