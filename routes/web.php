<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App ;

use Illuminate\Support\Facades\Route;

Route::get('/sms', 'SmsController@sendSMS');

Route::get('/', "Auth2\LoginController@index")->name('login');

Route::get('/neet-notif','SettingsController@meet_notif')->name('meet-notification');

Route::get('/zoom',"ZoomController@index");

Route::post("/Authenticate","Auth2\LoginController@authenticate")->name('login_auth');
Route::post('/settings','SettingsController@store')->name(('user.add'));
Route::post('/settings/update','SettingsController@update')->name(('doctor.update'));

Route::post('/settings/delete/','SettingsController@destroy')->name(('doctor.delete'));

Route::get('/settings', 'SettingsController@index');

Route::post('/zoom-meeting', 'ZoomController@store')->name('zoom.store');

Route::get('/patients', function () {
    if(Auth::check()){
        return view('doctor.dashboard.patients');
    }else{
        return view('doctor.login');
    }

   
});

Route::get('notif', function () {
   
    if (Auth::check() ) {
        return view('doctor.dashboard.notif');
    }
    else{
        return view('doctor.login');
    }
});


Route::get('set/{locale}', function ($lang) {
    session()->put('app_locale', $lang);
    return redirect()->back();
});

Route::get('add', function () {
    return view('patient.location');
});


Route::get('/dashboard', function () {

    if (Auth::check() ) {
        return view('doctor.dashboard.index');
    } else {
        return view('doctor.login');
    }
})->name('doctor.dashboard');



Route::get('/test-status', function () {

    if (Auth::check() ) {
        return view('doctor.dashboard.teststatus');
    } else {
        return view('doctor.login');
    }
})->name('doctor.test-status');


Route::get('/logout', 'Auth2\LoginController@logout')->name('logout');



Route::get('/patient-area', 'PatientController@index')->name('patient.begin');
Route::post('/patient-area', 'PatientController@store')->name('patient.store');
Route::post('/upload','PatientController@upload')->name('patient.upload');
Route::post('/update_meeting',"ZoomController@update")->name('meeting.update');



Route::post('/patientcheck', 'PatientController@check')->name('checkno');

Route::post('/patient-area/update','PatientController@get_patient')->name('get_patient');
Route::post('/patient-area/update2','PatientController@get_patient2')->name('get_patient2');

Route::post('/generate-csv','SettingsController@generateCSV')->name('generateCSV');
Route::get('/bulk-csv','SettingsController@bulkCSV')->name('bulk-generate');

Route::get('/patient-status', 'PatientController@status')->name('get_status');

Route::post('/patient-set', 'SettingsController@set')->name('accept_session');

Route::get('/timer', function () {
    return view('patient.timer');
})->name('patient.timer');  

Route::get('/upload', function () {
    return view('patient.upload');
});

// Route::get('/{locale}', function ($locale = null) {
//     App::setLocale($locale);
//     return redirect()->back();
// });

// Route::get('language/{locale}', function ($locale) {
//     app()->setLocale($locale);
    
//     Session('locale', $locale);
//     return redirect()->back();
// });
