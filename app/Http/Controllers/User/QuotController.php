<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\TeethTrait;
use App\Models\Devis;
use Auth;
use App\Repository\LigneDevisRepo;
use App\Repository\QuotationRepo;
use Symfony\Component\Routing\Router;

class QuotController extends Controller
{
    public $ligneDevis;
    public $devis;

    use TeethTrait;

    public function __construct(LigneDevisRepo $ligneDevis, QuotationRepo $quotationRepo)
    {
        $this->ligneDevis = $ligneDevis;
        $this->devis = $quotationRepo;
    }
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
        /* -------------------------- Create quotation -------------------------- */
        $lines = json_decode($request->lines);
        $quotID = $request->quotID;
        if ($quotID != "undefined") {
            // Update Quotation
            $quot = $this->devis->getByID($quotID);
            $line_ids = $this->saveLines($lines, $quot);
        } else {
            // Create new Quotation

            $created_quot = $this->devis->create($request->except(['quotID', 'lines']) + [
                'created_by' => Auth::id(),
                'state' => 'devis'
            ]);
            $line_ids = $this->saveLines($lines, $created_quot);
        }


        //* RETURN THE COORDS OF THE ACCEPTED LINES
        $lines = $this->ligneDevis->getByIdsWith(['act.coords', 'act.videos'], $line_ids);

        return response()->json($lines, 201);
    }
    /**
     * Create and store quotation lines into DB
     *
     * @param [type] $lines
     * @param [type] $quot
     * @return Integer  IDS of quotation lines
     */
    private function saveLines($lines, $quot)
    {
        foreach ($lines  as $line) {
            $line->tooth = $this->getToothFrom($line->tooth);
            $lineDevis = $this->ligneDevis->create($line, $quot->id);
            $line_ids[] = $lineDevis->id;
        }
        return $line_ids;
    }
    /**
     * Add new lines to the Quotation
     *
     * @param Request $req
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     **/
    public function createLines(Request $req)
    {

        /* ---------------- Create or retrieve the exesting Quotation --------------- */
        clock()->info($req->quot_id);
        if ($req->quot_id != "null") {
            $quotation = $this->devis->getByID($req->quot_id);
        } else {
            $quotation = $this->devis->create($req->except('lignes', 'quot_id') + [
                'created_by' => Auth::id(),
                'state' => 'plan'
            ]);
        }

        /* ------------- Create And associate new lines to the quotation ------------ */
        $lines = json_decode($req->lignes, true);
        if (count($lines) > 0) {
            $parsedLines = collect($lines)->map(function ($line) {
                return [
                    'num_dent'  => $this->getToothFrom($line['num_dent']),
                    'acte_id'   => $line['act_id'],
                    'price'     => $line['price'],
                    'state'     => "A faire",
                ];
            })->toArray();

            $lines = $this->devis->createLines($quotation, $parsedLines);

            return response()->json($lines->load('act.coords', 'act.videos'), 201);
        }

        return;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Devis $devis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $acceptedLines = json_decode($request->acceptedLines, true);

        //* GET THE ID'S OF THE ACCEPTED ACTS
        $acceptedLinesID = collect($acceptedLines)->map->id;

        //* CREATE OR UPDATE THE EXISTING PLAN
        $devis = $this->devis->createOrUpdatePlan($request);

        clock($acceptedLines, $acceptedLinesID, $devis);
        //* ADD THE ACCEPTED LINES TO THE EXISTING OR THE CREATED PLAN
        $this->devis->createOrPopulateLines($devis, $acceptedLines);

        //* CHANGE THE ACCEPTING LINES STATE OF THE CURRENT QUOTATION
        $this->ligneDevis->updateAcceptedStateByLinesID($acceptedLinesID);

        //* RETURN THE COORDS OF THE ACCEPTED LINES
        $lines = $this->ligneDevis->getByIdsWith(['act.coords', 'act.videos'], $acceptedLinesID);

        return response()->json($lines, 201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devis  $devis
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($devis)
    {
        return response()->json($this->devis->delete($devis));
    }

    /**
     * Duplicate quotation given by ID
     * Return the duplicated Quotation
     * @param int id
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateQuotation($id)
    {
        $duplicatedQuotation = Devis::find($id)->replicateRow();

        return response()->json($duplicatedQuotation->id, 201);
    }
}
