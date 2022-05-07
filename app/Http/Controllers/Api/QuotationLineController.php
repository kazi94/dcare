<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LigneDevis;
use App\Http\Requests\StoreLineQuotation;

class QuotationLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreLineQuotation $request, $id)
    {
        if ($request['state'] == "A faire") {
            $request['state']  = "En cours";
        } elseif ($request['state'] == "En cours") {
            $request['state']  = "fait";
        } else {
            $request['state']  = "A faire";
        }
        return response()->json(LigneDevis::where('id', $id)->update($request->except(['_method'])));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $line = LigneDevis::find($id);

        $devis_id = $line->devis_id;

        $line->delete();

        $devisCount = LigneDevis::where('devis_id', $devis_id)->count();

        //* DELETE QUOTATION IF NO LINE EXIST ANYMORE
        if ($devisCount == 0) {
            \App\Devis::find($devis_id)->delete();
        }

        return ["Status" => "deleted"];
    }
}
