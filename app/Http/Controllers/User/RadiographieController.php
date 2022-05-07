<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\Models\Radio;
use Auth;
use Illuminate\Support\Facades\Storage;

class RadiographieController extends Controller
{
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
    }

    /**
     * store request fields
     *
     * @return view
     * @author
     **/
    public function store(Request $request)
    {
        $uploadedFile = $request->file('file');
        $patient_id = $request->patient_id;
        $extension = $uploadedFile->extension();
        $fileNameToStore = '/storage/img/radios/' . time() . '.' .  $extension;
        $path = $request->file('file')->storeAs('/public/img/radios', time() . "." . $extension);

        $upload = new Radio;
        $upload->img_url    = $fileNameToStore;
        $upload->patient_id = $patient_id;
        $upload->created_by = $request->user()->id;
        $upload->save();

        return response()->json($upload, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
    }

    /**
     * Show the patient profile , and his folder :
     * auto , traitement , medical , biological analysis , phyto  *...etc
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
     * @author __KaziWhite**__SALAF4_WebDev**.
     */
    public function update(Request $request, $id)
    {
    }
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function destroy($id)
    {
        $radio = Radio::find($id);
        $url = str_replace("/storage", "public/", $radio->img_url);
        // delete from storage
        Storage::delete($url);
        return response()->json($radio->delete());
    }
}
