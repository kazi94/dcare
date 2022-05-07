<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class BibliothequeController extends Controller
{
    /**
     * Show the list of all videos demos
     *
     * @return void
     */
    public function index()
    {
        return view('bibliotheque.show');
    }
    /**
     * Show the list of all videos demos
     *
     * @return void
     */
    public function list()
    {
        $photos = \App\Models\Radio::whereCreatedBy(Auth::user()->id)->with('patient')->get();

        return response()->json($photos);
    }
    public function store(Request $req)
    {
        $urlToStore = 'img/radios/' . time() . '.' .  $req->file('img_url')->getClientOriginalExtension();
        $img_url = $req->file('img_url')->storeAs('public/img/radios', time() . '.' .  $req->file('img_url')->getClientOriginalExtension());

        $createdPhotoId = DB::table('radios')->insertGetId([
            'img_url' => "/storage/" . $urlToStore,
            'patient_id' => $req->patient_id,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // $createdPhoto = DB::table('radios')->where('id', $createdPhotoId)->first();

        $createdPhoto = App\Models\Radio::with('patient')->find($createdPhotoId);

        return response()->json($createdPhoto, 201);
    }
    /**
     * Return videos by category
     *
     * @param [type] $categ_id
     * @return void
     */
    public function getByPatient($id)
    {
        $photos = \App\Models\Radio::with('patient')->where('patient_id', $id)
            ->get();

        return response()->json($photos);
    }

    public function destroy(\App\Models\VideoDemo $videoDemo)
    {
        Storage::delete("public/" . substr($videoDemo->url, 8));

        return response()->json($videoDemo->delete());
    }
}
