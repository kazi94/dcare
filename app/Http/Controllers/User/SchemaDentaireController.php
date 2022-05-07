<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\Schema;
use App\Models\Traitement;
use App\Models\Formule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Debugbar;
use Illuminate\Support\Facades\Validator;

class SchemaDentaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Formule::whereFormulas('basic')->where('teeth', '!=', 0)->get();
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
        $tooth = json_decode($request->tooth);
        if (count($tooth) == 0) {
            return response()->json("Veuillez sélectionner au moins une dent.", 422);
        }


        $schema = Schema::firstOrCreate(
            [
                'patient_id' => $request->patient_id,
                'type' => 'initial'
            ],
            [
                'patient_id' => $request->patient_id,
                'type' => 'initial',
                'created_by' => Auth::user()->id
            ]
        );

        if ($request->formula) {
            $coords = Formule::whereIn('teeth', json_decode($request->tooth))
                ->whereIn('formulas', json_decode($request->formula))
                ->get();

            $formulas_id = collect($coords)->map(function ($e) {
                return $e->id;
            });

            $schema->traitements()->syncWithoutDetaching($formulas_id);
        }

        return response()->json(
            [
                'schema_id' => $schema->id,
                'coords'    => $coords
            ],
            201
        );
    }
    /**
     * Undocumented function
     *
     * @param [Integer] $schema
     * @param [Array] $ids
     * @param [Integer] $teeth
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    protected function syncTraitements($schema, $ids, $teeth)
    {
        foreach ($ids as $id) {
            //collect all inserted record IDs
            $ant_id_array[$id] = ['teeth' => $teeth];
        }
        $schema->traitements()
            ->wherePivot('teeth', $teeth)
            ->attach($ant_id_array);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schema  $schema
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Schema $schema)
    {
        //
    }
    /**
     * undocumented function summary
     *
     * return to the client the coords of the selected teeth or
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getCoords($teeth = null, $formulas)
    {
        // get the coords ,color of the selected formulas and teeth
        $coords = Formule::where('teeth', $teeth)
            ->whereIn('formulas', explode(",", $formulas))
            // ->where('teeth', '!=', 0)
            ->select('coord', 'color', 'formulas')
            ->get();

        return response()->json($coords, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schema  $schema
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Schema $schema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schema  $schema
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Schema $schema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $schema)
    {
        // Get Schema
        $schema = Schema::find($schema);

        //Get the Formula IDS given by name of formula and list of tooth
        $formula_ids = Formule::whereIn('teeth', json_decode($request->tooth))
            ->where('formulas', $request->formula)
            ->select('id')
            ->get();
        $formula_ids = collect($formula_ids)->map(function ($e) {
            return $e->id;
        });

        // detach from 'Traitements' table tooth from fomula
        $schema->traitements()->detach($formula_ids);

        return response()->json("success", 200);
    }

    public function removeTooth($toothToRemove)
    {
        $exp = explode(',', $toothToRemove);
        foreach ($exp as $val) {
            Traitement::where('num_dent', $val)->where('formule', '!=', null)->delete();
        }

        return response()->json([], 201);
    }


    /**
     * Get the basic forms from database
     *
     * @return void
     */
    public function getBasicForms()
    {
        return Formule::whereTeeth('0')->get();
    }
    /**
     * send to the client the list of formulas of selected teeth
     *
     * @param [type] $teeth
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Response List of formulas
     */
    public function getFormulasOfTeeth($id = null, $teeth)
    {

        //$formulas = Traitement::with('formulas')->whereIn('teeth', explode(',', $teeth))->where('schema_id', $id)->distinct();

        return $formulas = \DB::table('traitements')
            ->join('formules', 'traitements.formule_id', 'formules.id')
            ->where('traitements.teeth', $teeth)
            ->where('schema_id', $id)
            ->select('formules.formulas')
            ->get();
    }
}
