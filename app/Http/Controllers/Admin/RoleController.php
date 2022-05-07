<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Role::all(), 200);
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
        $this->validate($request, [
            'nom_profile' => 'required|string|max:60|unique:roles',
        ]);

        $role = new Role();

        $tableau = array('patient', 'prescription', 'auto', 'analyse_bio', 'traitement', 'question', 'phyto', 'et', 'consultation', 'fiche');
        $tableau1 = array('Patient', 'Prescription', 'Automédication', 'Analyse_biologique', 'Traitement_chronique', 'Phytothérapie', 'Questionnaire', 'Education_thérapeutique', 'Consultation', 'Fiche_de_conciliation');

        $role->nom_profile = $request->nom_profile;
        $role->analyse_ph = $request->analyse_ph;
        $role->medecin_presc = $request->medecin_presc;
        $role->cloner_prescription = $request->cloner_Prescription;

        for ($i = 0; $i < count($tableau); $i++) {
            //définir les noms des colonnes
            $x = 'lister_' . $tableau[$i];
            $y = 'ajouter_' . $tableau[$i];
            $z = 'modifier_' . $tableau[$i];
            $w = 'supprimer_' . $tableau[$i];
            $a = 'imprimer_' . $tableau[$i];
            $b = 'lister_details_' . $tableau[$i];
            $e = 'exporter_' . $tableau[$i];

            $x1 = 'lister_' . $tableau1[$i];
            $z1 = 'modifier_' . $tableau1[$i];
            $w1 = 'supprimer_' . $tableau1[$i];
            $a1 = 'imprimer_' . $tableau1[$i];
            $y1 = 'ajouter_' . $tableau1[$i];
            $b1 = 'détails_' . $tableau1[$i];
            $e1 = 'exporter_' . $tableau1[$i];

            $role->$x = $request->$x1;
            $role->$y = $request->$y1;
            $role->$z = $request->$z1;
            $role->$w = $request->$w1;
            $role->$a = $request->$a1;
            $role->$b = $request->$b1;
            $role->$e = $request->$e1;
        }

        $role->save(); // persist fields in the table 'roles'

        return redirect(route('profile.index'))->with('message', 'Porfil créer avec succés !');
        //$role->permissions()->sync($request->permission); // The `sync` method accepts an array of IDs to place on the intermediate table . Any IDs that are not in the given array will be removed from the intermediate table

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
        $role = Role::find($id);
        return view('admin.profile.edit', compact('role'));
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

        //validate resquest before store in DB
        $this->validate($request, [
            'nom_profile' => 'required|string|max:60',
            'permission[]' => 'digits:10'
        ]);

        $role = Role::find($id); // fetch row from id

        $tableau = array('patient', 'prescription', 'auto', 'analyse_bio', 'traitement', 'question', 'phyto', 'et', 'consultation', 'fiche');
        $tableau1 = array('Patient', 'Prescription', 'Automédication', 'Analyse_biologique', 'Traitement_chronique', 'Phytothérapie', 'Questionnaire', 'Education_thérapeutique', 'Consultation', 'Fiche_de_conciliation');

        $role->nom_profile = $request->nom_profile;
        $role->analyse_ph = $request->analyse_ph;
        $role->medecin_presc = $request->medecin_presc;
        $role->cloner_prescription = $request->cloner_Prescription;

        for ($i = 0; $i < count($tableau); $i++) {
            //définir les noms des colonnes
            $x = 'lister_' . $tableau[$i];
            $y = 'ajouter_' . $tableau[$i];
            $z = 'modifier_' . $tableau[$i];
            $w = 'supprimer_' . $tableau[$i];
            $a = 'imprimer_' . $tableau[$i];
            $b = 'lister_details_' . $tableau[$i];
            $e = 'exporter_' . $tableau[$i];

            $x1 = 'lister_' . $tableau1[$i];
            $z1 = 'modifier_' . $tableau1[$i];
            $w1 = 'supprimer_' . $tableau1[$i];
            $a1 = 'imprimer_' . $tableau1[$i];
            $y1 = 'ajouter_' . $tableau1[$i];
            $b1 = 'détails_' . $tableau1[$i];
            $e1 = 'exporter_' . $tableau1[$i];

            $role->$x = $request->$x1;
            $role->$y = $request->$y1;
            $role->$z = $request->$z1;
            $role->$w = $request->$w1;
            $role->$a = $request->$a1;
            $role->$b = $request->$b1;
            $role->$e = $request->$e1;
        }

        $role->save(); // persist fields in the table 'roles'

        return redirect(route('profile.index'))->with('message', 'Profil modifié avec succés !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();

        return redirect()->back();
    }
}
