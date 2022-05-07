<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Auth;
use Illuminate\Support\Facades\DB;

class MedicamentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Search Drugs
     *
     * @return void
     * @author
     **/
    public function search($query)
    {
        return DB::table('sp_specialite')
            ->join('pre_presentation', 'sp_specialite.sp_code_sq_pk', 'pre_presentation.pre_sp_code_fk')
            ->join('unites', 'unites.id', 'pre_presentation.pre_cdf_up_code_fk')
            ->where('sp_nom', 'like', '%' . $query . '%')
            ->select('sp_specialite.sp_code_sq_pk', 'sp_specialite.sp_nom', 'unites.unite_nom')
            ->limit(10)
            ->get();
    }


    // protected function getUnite($sp_id)
    // {
    //     $unite = DB::table('unites')
    //     ->join('pre_presentation' ,'unites.id','pre_presentation.pre_cdf_up_code_fk')
    //     ->where('pre_presentation.pre_sp_code_fk', $sp_id)
    //     ->select('unites.unite_nom')
    //     ->distinct()
    //     ->get();
    //     return $unite ? $unite : [];
    // }
}
