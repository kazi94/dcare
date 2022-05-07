<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VideoStoreRequest;

class VideoDemoController extends Controller
{
    /**
     * Show the list of all videos demos
     *
     * @return void
     */
    public function index()
    {
        return view('demos.show');
    }
    /**
     * Show the list of all videos demos
     *
     * @return void
     */
    public function list()
    {
        $videos = \App\Models\VideoDemo::with('act')->get();

        return response()->json($videos)->header('Accept-Ranges', 'bytes')->header('Content-Range', 'bytes 200-1000/67589');
    }
    public function store(VideoStoreRequest $req)
    {
        $urlToStore = 'videos_demo/' . time() . '.' .  $req->file('video_url')->getClientOriginalExtension();
        $video_url = $req->file('video_url')->storeAs('public/videos_demo', time() . '.' .  $req->file('video_url')->getClientOriginalExtension());

        $createdVideoId = DB::table('videos_demo')->insertGetId([
            'url' => "storage/" . $urlToStore,
            'act_id' => $req->act,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $createdVideo =
            \App\Models\VideoDemo::with('act')->where('id', $createdVideoId)->first();
        return response()->json($createdVideo, 201);
    }
    /**
     * Return videos by category
     *
     * @param [type] $categ_id
     * @return void
     */
    public function getByCategory($categ_id)
    {
        $videos = \App\Models\VideoDemo::join('actes', 'videos_demo.act_id', 'actes.id')
            ->join('categories', 'actes.category_id', 'categories.id')
            ->where('category_id', $categ_id)
            ->get();

        return response()->json($videos, 201);
    }

    public function destroy(\App\Models\VideoDemo $videoDemo)
    {
        Storage::delete("public/" . substr($videoDemo->url, 8));

        return response()->json($videoDemo->delete());
    }
}
