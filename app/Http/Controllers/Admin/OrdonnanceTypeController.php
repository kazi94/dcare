<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ordonnancetype;
use App\Models\OrdonnanceTypeLine;

class OrdonnanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ordonnances = Ordonnancetype::with('medicaments')->get();

        foreach ($ordonnances as $val) {
            $this->implodeMedicaments($val);
        }
        return response()->json($ordonnances, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return view('admin.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $ordonnance = new Ordonnancetype;
        $ordonnance->nom = ucfirst($request->nom);
        $ordonnance->save();

        foreach ($request->medicaments as $line) {
            $ordonnanceTypeLine = new OrdonnanceTypeLine;
            $ordonnanceTypeLine->medicament = $line['medicament'];
            $ordonnanceTypeLine->medicament_id = $line['medicament_id'];
            $ordonnanceTypeLine->nb_prise = $line['nb_prise'];
            $ordonnanceTypeLine->forme = $line['forme'];
            $ordonnanceTypeLine->frequence = $line['frequence'];
            $ordonnanceTypeLine->preview = $line['preview'];
            $ordonnanceTypeLine->ordonnancetype_id = $ordonnance->id;
            $ordonnanceTypeLine->save();
        }

        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(OrdonnanceType::with('medicaments')->findOrFail($id), 201);
    }

    /**
     * Show the form for editing the specified resource.
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
     */
    public function update(Request $request, $id)
    {
        $ordonnance = Ordonnancetype::find($id);
        $ordonnance->nom = ucfirst($request->nom);
        $ordonnance->save();


        OrdonnanceTypeLine::where('ordonnancetype_id', $id)->delete();

        return
            $this->addLignesOrdonnanceType($id, $request->medicaments) ?
            response()->json(['success' => 'Ordonnance Type modifiée avec succés!'], 200) : 'Erreur dans la modification !';



        return response()->json([], 200);
    }
    /**
     * Add lignes Prescriptions
     *
     * @return void
     * @author
     **/
    private function addLignesOrdonnanceType($id, $medicaments)
    {
        foreach ($medicaments as $line) {
            $ordonnanceTypeLine = new OrdonnanceTypeLine;
            $ordonnanceTypeLine->medicament = $line['medicament'];
            $ordonnanceTypeLine->medicament_id = $line['medicament_id'];
            $ordonnanceTypeLine->nb_prise = $line['nb_prise'];
            $ordonnanceTypeLine->forme = $line['forme'];
            $ordonnanceTypeLine->frequence = $line['frequence'];
            $ordonnanceTypeLine->preview = $line['preview'];
            $ordonnanceTypeLine->ordonnancetype_id = $id;
            $ordonnanceTypeLine->save();
        }

        return true;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Ordonnancetype::where('id', $id)->delete();

        return response()->json([], 200);
    }


    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getOrdonnancesType()
    {
        $ordonnances = OrdonnanceType::with('medicaments')->get();


        $ordonnances = $ordonnances->map(function ($e) {
            return [
                'value' => $e['id'],
                'text' => $e['nom'],
                'medicaments' => $e['medicaments']->map(function ($el) {
                    return $el['preview'];
                }),
            ];
        });

        $ordonnances->prepend([
            'value' => null,
            'text' => 'Veuillez sélectionner une ordonnance',
            'medicaments' => null
        ]);

        return response()->json($ordonnances, 201);
    }

    protected function implodeMedicaments($ordonnance)
    {
        $ordonnance['imploded'] = implode(',', array_map(function ($v) {
            return $v['medicament'];
        }, $ordonnance->medicaments->toArray()));
    }
}
