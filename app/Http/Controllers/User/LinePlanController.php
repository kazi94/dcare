<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LigneDevis;

class LinePlanController extends Controller
{
    public function updatePrice($id, Request $request)
    {
        return LigneDevis::where('id', $id)->update($request->all());
    }
}
