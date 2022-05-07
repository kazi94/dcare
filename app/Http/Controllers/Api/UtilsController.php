<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use DB;

class UtilsController extends Controller
{

    public function getDiseases()
    {
        return response()->json([
            'pathologies' => $this->getPathologies(),
            'antecedents' => $this->getAntecedents(),
        ]);
    }

    protected function getPathologies()
    {
        return DB::table('pathologies')->get();
    }
    protected function getAntecedents()
    {
        return DB::table('antecedents')->get();
    }
}
