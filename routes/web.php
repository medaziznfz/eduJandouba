<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtabDashboardController;
use App\Http\Controllers\RegistrationCompletionController;
use App\Http\Controllers\FormationController;
use App\Models\Etablissement;
use App\Http\Controllers\UserFormationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UniversityApplicationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


use Illuminate\Support\Facades\Mail;
use App\Mail\SimpleTestMail;

Route::get('/test-email', function () {
    $user = App\Models\User::first();
    Mail::to($user->email)->send(new SimpleTestMail($user));
    return 'Email sent successfully!';
});



Route::get('/test-env', function () {
    dd(env('MAIL_MAILER'));  // Dump the value of MAIL_MAILER
});

Route::get('/test-env-vars', function () {
    dd(
        env('APP_NAME'),        // Should print 'local' if the environment is correct
        env('APP_URL'),      // Should print 'true' if debugging is enabled
        env('MAIL_MAILER')     // Should print 'log' based on your .env configuration
    );
});


use App\Mail\TestEmail;

Route::get('/send-test-email', function () {
    // Send the test email
    Mail::to('medaziznefzi1@gmail.com')->send(new TestEmail());

    // Return a response
    return 'Test email sent and logged!';
});






Route::get('/', function () {
     // Récupère tous les établissements
     $etablissements = Etablissement::all();
 
     // Passe-les à la vue welcome
     return view('welcome', compact('etablissements'));
 });

// 🔹 Demande d’inscription
Route::get('/request', [RequestController::class, 'create']);
Route::post('/request', [RequestController::class, 'store'])->name('request.store');
Route::get('/request/statut', [RequestController::class, 'showStatusForm'])
     ->name('request.status.form');
Route::post('/request/statut', [RequestController::class, 'checkStatus'])
     ->name('request.status.check');


Route::get('/application/{application}/confirm/{hash}', [UserController::class, 'confirm'])
    ->name('user.application.confirm');


// 🔹 Complétion de l’inscription (lien envoyé par email)
Route::get('/complete-registration/{token}', 
    [RegistrationCompletionController::class, 'showForm']
)->name('registration.complete');
Route::post('/complete-registration/{token}', 
    [RegistrationCompletionController::class, 'submitForm']
)->name('registration.submit');

// 🔹 Authentification
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Dashboard « user »
Route::middleware(['auth','role:user'])->group(function () {
    // Dashboard utilisateur
    Route::get('/user/dashboard', fn() => view('user.dashboard'))
         ->name('user.dashboard');

    // Liste des formations
    Route::get('/user/formations', [UserFormationController::class, 'index'])
         ->name('user.formations.index');

    // Détails d’une formation
    Route::get('/user/formations/{formation}', [UserFormationController::class, 'show'])
         ->name('user.formations.show');

     Route::post(
          '/user/formations/{formation}/request',
          [UserFormationController::class, 'request']
      )->name('user.formations.request');
});

// 🔹 Dashboard validateur établissement (« etab »)
Route::middleware(['auth','role:etab'])->group(function () {
    // Liste & actions sur les demandes
    Route::get('/etab/dashboard', [EtabDashboardController::class, 'index'])
         ->name('etab.dashboard');
    Route::post('/etab/demande/{demande}/update-status', 
         [EtabDashboardController::class, 'updateStatus']
    )->whereNumber('demande');
    Route::post('/etab/demande/{demande}/decline', 
         [EtabDashboardController::class, 'decline']
    )->whereNumber('demande');
    Route::post('/etab/demandes/batch-update', 
         [EtabDashboardController::class, 'batchUpdate']
    )->name('etab.demandes.batchUpdate');
    Route::delete('/etab/demande/{demande}', 
         [EtabDashboardController::class, 'destroy']
    )->whereNumber('demande');
    Route::delete('/etab/demandes/batch-delete', 
         [EtabDashboardController::class, 'batchDestroy']
    )->name('etab.demandes.batchDestroy');
});

// ▸ Routes for “etab” role: APPLICATIONS

// routes/web.php

Route::middleware(['auth','role:etab'])
     ->prefix('etab')
     ->name('etab.')
     ->group(function () {
         Route::get('applications', [ApplicationController::class, 'index'])
              ->name('applications.index');

         Route::post('applications/{application}/accept',  [ApplicationController::class, 'accept'])
              ->name('applications.accept');

         Route::post('applications/{application}/reject',  [ApplicationController::class, 'reject'])
              ->name('applications.reject');

         // ← la route restore
         Route::post('applications/{application}/restore', [ApplicationController::class, 'restore'])
              ->name('applications.restore');

         Route::delete('applications/{application}',      [ApplicationController::class, 'destroy'])
              ->name('applications.destroy');
     });





Route::prefix('univ')->middleware(['auth','role:univ'])->name('univ.')->group(function(){
          Route::get('applications',                   [UniversityApplicationController::class,'index'])->name('applications.index');
          Route::post('applications/{application}/accept',   [UniversityApplicationController::class,'accept'])->name('applications.accept');
          Route::post('applications/{application}/waitlist',[UniversityApplicationController::class,'waitlist'])->name('applications.waitlist');
          Route::post('applications/{application}/reject',   [UniversityApplicationController::class,'reject'])->name('applications.reject');
          Route::post('applications/{application}/restore',  [UniversityApplicationController::class,'restore'])->name('applications.restore');
          Route::delete('applications/{application}',       [UniversityApplicationController::class,'destroy'])->name('applications.destroy');
      });
      
 


Route::middleware(['auth','role:univ'])
     ->prefix('univ')
     ->name('univ.')
     ->group(function () {
    // Dashboard home
    Route::view('dashboard','univ.dashboard')->name('dashboard');

    // Full CRUD for Formations
    Route::resource('formations', FormationController::class);
});


// 🔹 Dashboard super-utilisateur (« super »)
Route::middleware(['auth','role:super'])->group(function () {
    Route::get('/super/dashboard', fn() => view('super.dashboard'))
         ->name('super.dashboard');
});
