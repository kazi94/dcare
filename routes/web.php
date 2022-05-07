<?php
// Routes for user authentification and registration



Auth::routes();

Route::get('/', function () {
    if (Auth::user()) return redirect('acceuil');
    else return view('auth.login');
});
Route::get('/gcal', function () {
    return view('gcalendar');
});
Route::resource('/patients/devis/lines', 'Api\QuotationLineController');
Route::get('/acceuil', 'HomeController@index')->name('home.index');

/*//*******************ADMINISTRATION MODULE//*******************::*/
Route::prefix('/admin')->namespace('Admin')->middleware(['auth'])->group(function () {
    Route::get('role/get-roles', 'RoleController@getRoles');
    Route::resource('role', 'RoleController');
    Route::get('reglages/general', 'SettingController@getSettings');
    Route::post('reglages', 'SettingController@store');
    Route::post('user/{id}/reset-password', 'UserController@reset');
    Route::resource('user', 'UserController');
    Route::get('ordonnance-type/get-ordonnances-type', 'OrdonnanceTypeController@getOrdonnancesType');
    Route::resource('ordonnance-type', 'OrdonnanceTypeController');
    Route::get('act/get-acts-by-category', 'ActController@getActsGroupByCategory');
    Route::post('act/get-coords-by-acts', 'ActController@getCoordsByActs');
    Route::get('act/get_categories', 'ActController@getCategories');
    Route::resource('act', 'ActController');
    Route::get('category/get-categories-with-acts', 'CategoryController@getCategoriesWithActs');
    Route::resource('category', 'CategoryController');
});
/*//*******************END ADMINISTRATION MODULE//*******************::*/


//*******************USER ROUTES//*******************::
Route::middleware(['auth'])->namespace('User')->group(function () {

    //*******************APPOINTEMENT MODULE*******************************
    Route::resource('/rendez-vous', 'AppointementController', ['names' => 'appointement']);
    // Route::post('/appointement/storePatient', 'AppointementController@storePatient')->middleware('auth');
    //*******************END APPOINTEMENT MODULE*******************************

    //*******************PATIENT MANAGEMENT MODULE//*******************::
    /* -------------------------- Dental schema routes -------------------------- */
    Route::resource('/patients/schema-dentaire', 'SchemaDentaireController');
    Route::get('/patients/schema-dentaire/get-coords/{teeth}&&formules={formulas}', 'SchemaDentaireController@getCoords');
    Route::delete('/patients/schema-dentaire/remove_tooth/{toothToRemove}', 'SchemaDentaireController@removeTooth');
    Route::get(
        '/schema/get-basic-forms',
        'SchemaDentaireController@getBasicForms'
    );
    Route::get('/patients/schema-dentaire/{id?}/teeth/{teeth}/get-formulas', 'SchemaDentaireController@getFormulasOfTeeth');

    /* ---------------------------- // Patient routes --------------------------- */
    /* ------------------------- // Radiographie routes ------------------------- */
    Route::resource('/patients/radiographies', 'RadiographieController');

    /* --------------------------- // Utilities routes -------------------------- */
    // Route::get('pathologies', 'PatientController@getPathologies');
    // Route::get('antecedents', 'PatientController@getAntecedents');
    /* -------------------------------------------------------------------------- */
    //* ------------------------- // Prescription routes ------------------------- */
    Route::resource('/patients/prescription', 'PrescriptionController');
    Route::get('/patients/prescription/{id}/print', 'PrescriptionController@print');
    /* -------------------------------------------------------------------------- */
    /* --------------------------- // Quotation routes -------------------------- */
    Route::post('/patients/devis/add-acts', 'QuotController@createLines');
    Route::post('/patients/devis/{id}/duplicate', 'QuotController@duplicateQuotation');
    // Route::get('/patients/devis/line/{state}&&{ligne_id}', 'QuotController@updateLigne');
    Route::resource('/patients/devis', 'QuotController');


    /* --------------------------- // Line Plan routes -------------------------- */
    Route::post('/api/patients/plan/lines/{id}', 'LinePlanController@updatePrice');

    /* ----------------------------- // Drugs routes ---------------------------- */
    Route::get('/medicament/{query}', 'MedicamentController@search');
    // Route::post('/medicamentDci','MedicamentController@getMedicamentDci');
    /* -------------------------------------------------------------------------- */
    //*******************END PATIENT MANAGEMENT MODULE//*******************::

    Route::resource('prescriptions', 'PrescriptionController');
    Route::resource('honoraires', 'PaymentController', ['names' => 'payments']);
});

//*******************API ROUTES//*******************::
Route::prefix('/api')->middleware(['auth'])->namespace('Api')->group(function () {

    /*
    * Memo Routes
    */
    Route::resource('memo', 'MemoController');
    /*
     * Patients Routes
     */
    Route::get('patientss/get-with-debt', 'PatientController@getWithDebt')->name('blabla');
    Route::get('patient/get-with-total-paid', 'PatientController@getAllWithTotalPaid')->name('patients.with.total.paid');
    Route::get('patients/search/{input}', 'PatientController@searchPatient');
    Route::get('patients/search/{input}/with-total-paid', 'PatientController@getTotalPaidOfSearchedPatient');
    Route::resource('patients', 'PatientController');

    /*
     * Prescriptions Routes
     */
    Route::get(
        'prescriptions',
        'PrescriptionController@index'
    );
    Route::delete('prescriptions/{prescription}', 'PrescriptionController@destroy');

    /*
     * Payments Routes
     */
    Route::get(
        '/patients/devis/add-acts',
        'PaymentController@index'
    );
    Route::delete('payments/{payment}', 'PaymentController@destroy')->middleware('can:payment.delete');
    Route::post('payments', 'PaymentController@store');
    Route::get('payments', 'PaymentController@index');
    Route::get('payments/today', 'PaymentController@getOfToday');
    Route::post(
        'patients/payments',
        'PaymentController@storeByPatient'
    );
    Route::get("payments/paid-by/{id}", 'PaymentController@getByUser');
    Route::get("payments/paid-by/{id}/today", 'PaymentController@getByUserOfToday');
    Route::put('patients/payments/{id}', 'PaymentController@update');

    /*
     * Videos Demos Routes
     */
    Route::post('videos-demo', 'VideoDemoController@store');
    Route::get('videos-demo', 'VideoDemoController@list');
    Route::delete('videos-demo/{videoDemo}', 'VideoDemoController@destroy');
    Route::get('videos-demo/get-by-category/{categ_id}', 'VideoDemoController@getByCategory');

    /*
     * My Bibliotheque Routes
     */
    Route::get('my-photos', 'BibliothequeController@list');
    Route::post('my-photos', 'BibliothequeController@store');
    Route::get('my-photos/get-by-patient/{id}', 'BibliothequeController@getByPatient');
    Route::get('utils', 'UtilsController@getDiseases');

    /*
     * Users Routes
     */
    Route::get('users/get-auth-user', 'UserController@getAuthUser');
    Route::resource('users', 'UserController');

    /*
     * Statistic Routes
     */
    Route::get(
        'statistic/daily-data',
        'DashboardController@getDailyData'
    );
    Route::get('statistic/to-day-appointements', 'DashboardController@getToDayAppointements');
    Route::get('statistic/patients/get-by-age/{period?}', 'DashboardController@getPatientsByAge');
    Route::get('statistic/patients/get-by-sexe/{period?}', 'DashboardController@getPatientsBySexe');
    Route::get(
        'statistic/acts/get-by-time/{period?}',
        'DashboardController@getActsByTime'
    );
    Route::get('statistic/acts/get-acts-done/{period?}', 'DashboardController@getActsDone');
    Route::get(
        'statistic/acts/sum-acts-done-per-category/{period?}',
        'DashboardController@sumTotalActsDoneByCategory'
    );
    Route::get('statistic/acts/sum-acts-done/{period?}', 'DashboardController@sumTotalActsDone');
    Route::get('statistic/patients/get-by-acts/{period?}', 'DashboardController@getPatientsByActs');
    Route::get('statistic/patients/get-by-motivations/{period?}', 'DashboardController@getPatientsByMotivations');
    Route::get('statistic/patients/get-by-categories/{period?}', 'DashboardController@getPatientsByCategories');
    Route::get('statistic/payments/get-by-month/{period?}', 'DashboardController@getTotalPaymentsByMonth');
    Route::get('statistic/payments/get-total-debtor', 'DashboardController@getTotalDebtor');
});
Route::post('/api/appointements/{id}/update-state', 'User\AppointementController@updateState');
Route::get('/api/appointements/from-today', 'User\AppointementController@getUpcomingEvents');
Route::post('/api/appointements/sync', 'User\AppointementController@syncAppointements');
Route::get('/api/logout', 'Auth\LoginController@logout');
Route::get('/videos-demo', 'Api\VideoDemoController@index')->name('demos.index');
Route::get('/ma-bibliotheque', 'Api\BibliothequeController@index')->name('bibliotheque.index');

Route::middleware('auth')->get('/{any}', function () {
    return view('main');
})->where('any', '.*');
