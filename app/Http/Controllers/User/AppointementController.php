<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\Models\Patient;
use App\Models\Category;
use App\User;
use App\Models\Appointement;
use App\Repository\AppointementRepo;
use Auth;
use DB;

class AppointementController extends Controller
{
    public $appointement;

    public function __construct(AppointementRepo $appointementRepo)
    {
        $this->appointement = $appointementRepo;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    // public function search() {
    //     $terme  = $_POST['phrase'];
    //      return $result = DB::table('patients')->where('nom' ,'LIKE' , '%'.$terme.'%')->orWhere('prenom' , 'LIKE' ,'%'.$terme.'%')->get();

    // }

    public function index()
    {

        // if (Auth::user()->cant('patients.view')) return redirect()->back();

        $users = \App\User::where('role_id', '!=', '3')->where('id', '!=', 5)->get();
        $categories = \App\Models\Category::all();

        return view('appoint.appointement', compact('users', 'categories'));
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
     * Store a newly created resource in storage from Calendar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // $d = json_decode($request->category);
        $request['start_date'] = $request->date_rdv . " " . $request->start_date;
        $request['end_date']   = $request->date_rdv . " " . $request->end_date;
        $request->request->add(['created_by' =>  Auth::user()->id]);
        if (!isset($request->assign_to)) {
            $request->request->add(['assign_to' =>  Auth::user()->id]);
        }

        $request->request->add(['color' =>  $this->getColor($request->assign_to)]);

        try {
            $patient = Patient::findOrFail($request->patient_id);
        } catch (\Throwable $th) {
            $patient = new Patient;
            $patient->nom = $request->patient_id;
            $patient->prenom = $request->patient_id;
            $patient->save();
        }



        $request['patient_id'] = $patient->id;
        $appoint = Appointement::create($request->except(['text', 'date_rdv', 'acte', 'category', 'up_patient_id', 'patient_key', 'patient_label', 'patient_motivationFr', 'description']) + ['text' => $request->acte]);

        return response()->json([
            "action" => "inserted",
            "tid" => $appoint->id
        ]);
    }

    /**
     * get color of the category
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    private function getColor($cat_id)
    {
        return User::find($cat_id)['color'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse To calendar
     */
    public function show($id)
    {
        if ($id != 'null') {
            $appointements = Appointement::with('patient', 'category', 'assignedTo', 'createdBy')->where('assign_to', $id)->get();
        } else {
            // $appointements = Appointement::where('created_by',Auth::id())->get();
            $appointements = Appointement::with('patient', 'category', 'assignedTo', 'createdBy')->get();
        }

        //Returned Format should be : { value : '' , label : ''}
        $patients = Patient::select('id as value', DB::raw("CONCAT(nom, ' ',prenom) as label"))->get();


        $categories = Category::select('id as value', "name as label", "color")->get();

        $users = \App\User::select('id as value', DB::raw("CONCAT(name, ' ',prenom) as label"))
            ->where('role_id', '!=', 3)
            ->get();

        return response()->json([
            "data"        => $appointements,
            "collections" => [
                "patients" => $patients,
                "categories" => $categories, // add to list of lightbox
                "users" => $users
            ]
        ]);
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
        try {
            if (isset($request->up_patient_id)) {
                $patient = Patient::findOrFail($request->up_patient_id);
            } else {
                $patient = Patient::findOrFail($request->patient_id);
            }
        } catch (\Throwable $th) {
            $patient = new Patient;
            $patient->nom = $request->up_patient_id;
            $patient->prenom = $request->up_patient_id;
            $patient->save();
        }



        $request['patient_id'] = $patient->id;
        $event             = Appointement::find($id);
        $event->text       = strip_tags($request->text);
        $event->patient_id = $request->patient_id;
        $event->start_date = $request->start_date;
        $event->fauteuil = $request->fauteuil;
        $event->end_date   = $request->end_date;
        $event->updated_by = Auth::id();
        $event->assign_to  = $request->assign_to;
        $event->category_id = $request->category_id;
        $event->color   = User::find($request->assign_to)->color;
        $event->save();

        return response()->json([
            "action" => "updated"
        ]);
    }


    public function destroy($id)
    {
        $event = Appointement::find($id);
        $event->delete();

        return response()->json([
            "action" => "deleted"
        ]);
    }

    public function updateState(Request $request, $id)
    {
        try {
            Appointement::where('id', $id)->update(['state' => $request->state, 'state_modified_at' => now()]);
            return $this->appointement->getByIdWithRelations($id);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    /**
     * Undocumented function
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function getUpcomingEvents()
    {

        try {
            return response()->json($this->appointement->getUpcoming()->map->only(['id', 'start_date', 'end_date', 'text', 'event_id']), 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function syncAppointements(Request $request)
    {
        //* TRANSFORM STRING REQUREST TO ARRAY
        // $calendarEventsId = json_decode($request->calendarEventsId, true);

        //* ADD CALENDAR EVENTS ID TO APPOINTEMENTS TABLE
        // foreach ($calendarEventsId as $calendarEventId) {
        $app = Appointement::find($request->calendarEventsId['id']);
        $app->event_id = $request->calendarEventsId['event_id'];
        $app->save();
        // }

        return response()->json($request);
    }
}
