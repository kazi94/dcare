<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActRequest;
use Illuminate\Database\Query\Builder;
use App\Models\Acte;
use App\Models\Category;
use App\Traits\TeethTrait;
use DB;
use Auth;


class ActController extends Controller
{
    use TeethTrait;
    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $acts = Acte::with('category')->get();

        return response()->json($acts, 200);
    }

    public function getCategories()
    {
        return Category::all();
    }
    /**
     * Summary of create
     * @return void
     */
    public function create()
    {
    }

    /**
     * Summary of store
     * @param StoreActRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreActRequest $request)
    {
        $act = new Acte;
        $act->code_cnas    = $request->code_cnas;
        $act->nom          = $request->nom;
        $act->type         = $request->type;
        $act->shortcut     = $request->shortcut;
        $act->category_id  = $request->category;
        $act->price        = $request->price;
        $act->save();
        if ($request->formes) {
            $formes = collect($request->formes)->map(function ($forme) {

                // Get Formes IDS ASSOC TO FORMULA NAME
                $formulas_ids = $this->getFormesIDByName($forme['formulas']);

                return [
                    'formulas' => $formulas_ids,
                    'color' => $forme['color']
                ];
            });
            foreach ($formes as $forme) {
                foreach ($forme['formulas'] as $formulas_id) {
                    $formes_id_array[$formulas_id->id] = ['color' => $forme['color']];
                }
            }

            $act->coords()->sync($formes_id_array);
        }

        return response()->json(Acte::with('category', 'coords')->find($act->id), 200);
    }

    /**
     * Get ID Formulas by Name of Formulas
     *
     * @param $formulas
     * @return Array ID Identifiant of formulas
     */
    private function getFormesIDByName($formulas)
    {
        return \App\Models\Formule::where('formulas', $formulas)->where('teeth', '!=', '0')->select('id')->get();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return;
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
     * Summary of update
     * @param StoreActRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreActRequest $request, $id)
    {


        $act = Acte::find($id);
        $act->code_cnas = $request->code_cnas;
        $act->nom       = $request->nom;
        $act->type      = $request->type;
        $act->shortcut  = $request->shortcut;
        $act->category_id = $request->category;
        $act->price = $request->price;
        $act->save();
        if ($request->formes) {

            $formes = collect($request->formes)->map(function ($forme) {

                // Get Formes IDS ASSOC TO FORMULA NAME
                $formulas_ids = $this->getFormesIDByName($forme['formulas']);

                return [
                    'formulas' => $formulas_ids,
                    'color' => $forme['color']
                ];
            });
            foreach ($formes as $forme) {
                foreach ($forme['formulas'] as $formulas_id) {
                    $formes_id_array[$formulas_id->id] = ['color' => $forme['color']];
                }
            }

            $act->coords()->sync($formes_id_array);
        }
        return response()->json(Acte::with('category', 'coords')->find($id), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Acte::where('id', $id)->delete();

        return response()->json([], 200);
    }
    /**
     * return list of acts group by category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActsGroupByCategory()
    {
        return response()->json(Category::with('acts')->get());
    }

    /**
     * Return Coords by Tooth and Acts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoordsByActs(Request $req)
    {
        $acts = json_decode($req->acts);

        // Get THE Coords
        $coords = collect($acts)->map(function ($act) {
            // GET NUM TOOTH
            $tooth = $this->getToothFrom($act->tooth);
            return Acte::with(['coords' => function ($query) use ($tooth) {
                $query->whereIn('teeth', explode(',', $tooth));
            }])->find($act->act_id);
        });

        return response()->json($coords, 200);
    }
}
