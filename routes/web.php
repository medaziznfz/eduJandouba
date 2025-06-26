<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtabController;
use App\Http\Controllers\RegistrationCompletionController;
use App\Http\Controllers\FormationController;
use App\Models\Etablissement;
use App\Http\Controllers\UserFormationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UniversityApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyFormationController;
use App\Http\Controllers\UnivDashController;
use App\Http\Controllers\PasswordResetCodeController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Formulaire pour demander un code (email + CIN + téléphone)
Route::get('/reset-password-request', function () {
    return view('auth.request-reset-code'); // formulaire d'envoi du code
})->name('password.code.form');

// Traitement du formulaire d'envoi du code (POST)
Route::post('/send-reset-code', [PasswordResetCodeController::class, 'sendCode'])->name('password.code.send');

// Formulaire pour vérifier le code reçu par mail
Route::get('/verify-reset-code', [PasswordResetCodeController::class, 'showVerifyCodeForm'])->name('password.code.form.verify');

// Vérification du code (POST)
Route::post('/verify-reset-code', [PasswordResetCodeController::class, 'verifyCode'])->name('password.code.verify');


// Route pour renvoyer le code par email sans re-saisie des infos
Route::post('/resend-reset-code', [PasswordResetCodeController::class, 'resendCode'])->name('password.code.resend');


// Formulaire de réinitialisation du mot de passe
// Formulaire de réinitialisation du mot de passe sécurisé
Route::get('/reset-password', function () {
    if (!session('password_reset_allowed') || !session('password_reset_email')) {
        return redirect()->route('password.code.form')->withErrors(['access' => 'Accès refusé. Veuillez suivre la procédure correcte.']);
    }

    $email = session('password_reset_email');
    return view('auth.reset-password', ['email' => $email]);
})->name('password.reset.form');

// Soumission du formulaire
Route::post('/reset-password', [PasswordResetCodeController::class, 'resetPassword'])->name('password.reset.submit');




use App\Http\Controllers\QRScannerController;

Route::get('/scan', [QRScannerController::class, 'scan'])->name('qrscanner.scan');
Route::get('/certificate/{hash}', [QRScannerController::class, 'showCertificate'])->name('qrscanner.show');


use App\Http\Controllers\NotificationController;

// Route for viewing notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Route to mark a specific notification as read
Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');

// Route to mark all notifications as read
Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

// Route for sending test notifications
Route::get('/test-notification', function() {
    notify(4, 'Test Notification', 'This is a test notification', '/dashboard');
    return 'Notification sent!';
});




use App\Http\Controllers\QRController;

// Route to display the QR code generation page (optional)
Route::get('/qrcode', [QRController::class, 'index'])->name('qrcode.index');

// Route to generate and display the QR code
Route::get('/generate-qrcode', [QRController::class, 'create'])->name('generate.qrcode');

Route::get('/application/{application}/{hash}/confirm', [UserController::class, 'index'])->name('user.application.index');
Route::post('/application/{application}/{hash}/confirm', [UserController::class, 'confirmAction'])->name('user.application.confirmAction');
Route::post('/application/{application}/{hash}/decline', [UserController::class, 'declineAction'])->name('user.application.declineAction');


// Routes for confirming or rejecting a user's application
Route::post('/user/formations/{formation}/confirm-or-reject', [UserFormationController::class, 'confirmOrReject'])
    ->name('user.formations.confirm_or_reject');

use App\Http\Controllers\DetailsSettingsController;

Route::middleware(['auth'])->group(function () {
    // Route to show the profile page
    Route::get('/profile', [DetailsSettingsController::class, 'index'])->name('profile.index');
    
    // Route to handle the profile update form submission
    Route::post('/profile/update', [DetailsSettingsController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [DetailsSettingsController::class, 'changePassword'])->name('profile.password.update');
});


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

     Route::get('/formation/{id}/download-pdf', [UserFormationController::class, 'downloadPDF'])->name('formation.downloadPDF');
     
     Route::get('/user/my-formations', [MyFormationController::class, 'index'])->name('user.myFormations');
});

// 🔹 Dashboard validateur établissement (« etab »)
Route::middleware(['auth','role:etab'])->group(function () {


     Route::get('/etab/dashboard', fn() => view('etab.dashboard'))
         ->name('etab.dashboard');
    // Liste & actions sur les demandes
    Route::get('/etab/resuests', [EtabController::class, 'index'])
         ->name('etab.requests');
    Route::post('/etab/demande/{demande}/update-status', 
         [EtabController::class, 'updateStatus']
    )->whereNumber('demande');
    Route::post('/etab/demande/{demande}/decline', 
         [EtabController::class, 'decline']
    )->whereNumber('demande');
    Route::post('/etab/demandes/batch-update', 
         [EtabController::class, 'batchUpdate']
    )->name('etab.demandes.batchUpdate');
    Route::delete('/etab/demande/{demande}', 
         [EtabController::class, 'destroy']
    )->whereNumber('demande');
    Route::delete('/etab/demandes/batch-delete', 
         [EtabController::class, 'batchDestroy']
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
      
// Route to handle launching the formation
Route::middleware(['auth', 'role:univ'])
    ->post('/univ/formations/{formation}/launch', [FormationController::class, 'launch'])
    ->name('univ.formations.launch');

Route::middleware(['auth', 'role:univ'])
    ->post('/univ/formations/{formation}/completed', [FormationController::class, 'completed'])
    ->name('univ.formations.completed');



use App\Http\Controllers\SettingsController;

Route::middleware(['auth','role:univ'])->prefix('univ/settings')->group(function(){
    // Show both tabs
    Route::get('/', [SettingsController::class, 'index'])
         ->name('univ.settings.index');

    // Grades
    Route::post('grades',       [SettingsController::class, 'storeGrade'])
         ->name('univ.settings.grades.store');
    Route::patch('grades/{grade}', [SettingsController::class, 'updateGrade'])
         ->name('univ.settings.grades.update');
    Route::delete('grades/{grade}', [SettingsController::class, 'destroyGrade'])
         ->name('univ.settings.grades.destroy');

    // Etablissements
    Route::post('etablissements',       [SettingsController::class, 'storeEtablissement'])
         ->name('univ.settings.etablissements.store');
    Route::patch('etablissements/{etablissement}', [SettingsController::class, 'updateEtablissement'])
         ->name('univ.settings.etablissements.update');
    Route::delete('etablissements/{etablissement}', [SettingsController::class, 'destroyEtablissement'])
         ->name('univ.settings.etablissements.destroy');
});





Route::middleware(['auth', 'role:univ'])
    ->prefix('univ')
    ->name('univ.')
    ->group(function () {

        // Dashboard home - via controller et méthode index
        Route::get('dashboard', [UnivDashController::class, 'index'])->name('dashboard');

        // Full CRUD for Formations
        Route::resource('formations', FormationController::class);
    });


use App\Http\Controllers\UserManagementController;

Route::middleware(['auth', 'role:univ'])->group(function () {
    // Routes for User Management
    Route::get('/univ/users', [UserManagementController::class, 'index'])->name('univ.users.index');
    Route::get('/univ/users/create', [UserManagementController::class, 'create'])->name('univ.users.create');
    Route::post('/univ/users', [UserManagementController::class, 'store'])->name('univ.users.store');
    Route::get('/univ/users/{user}/edit', [UserManagementController::class, 'edit'])->name('univ.users.edit');
    Route::put('/univ/users/{user}', [UserManagementController::class, 'update'])->name('univ.users.update');
    Route::delete('/univ/users/{user}', [UserManagementController::class, 'destroy'])->name('univ.users.destroy');
});



use App\Http\Controllers\EtabUserManagementController;


Route::middleware(['auth', 'role:etab'])->group(function () {
    // Routes for Etab User Management
    Route::get('/etab/users', [EtabUserManagementController::class, 'index'])->name('etab.users.index');
    Route::get('/etab/users/create', [EtabUserManagementController::class, 'create'])->name('etab.users.create');
    Route::post('/etab/users', [EtabUserManagementController::class, 'store'])->name('etab.users.store');
    Route::get('/etab/users/{user}/edit', [EtabUserManagementController::class, 'edit'])->name('etab.users.edit');
    Route::put('/etab/users/{user}', [EtabUserManagementController::class, 'update'])->name('etab.users.update');
    Route::delete('/etab/users/{user}', [EtabUserManagementController::class, 'destroy'])->name('etab.users.destroy');
});





// 🔹 Dashboard formateur (« forma »)
Route::middleware(['auth','role:forma'])->group(function () {
    Route::get('/forma/dashboard', fn() => view('forma.dashboard'))
         ->name('forma.dashboard');
});


// routes/web.php
use App\Http\Controllers\FormateurFormationController;

Route::middleware(['auth','role:forma'])
     ->prefix('forma')
     ->name('forma.')
     ->group(function() {
    Route::get('formations',      [FormateurFormationController::class,'index'])
         ->name('formations.index');
    Route::get('formations/{formation}', [FormateurFormationController::class,'show'])
         ->name('formations.show');

    Route::post('formations/{formation}/launch',    [FormateurFormationController::class,'launch'])
         ->name('formations.launch');
    Route::post('formations/{formation}/completed',[FormateurFormationController::class,'completed'])
         ->name('formations.completed');

    // **Remove** the GET /presence route
    // Route::get('formations/{formation}/presence', [FormateurFormationController::class,'presence'])
    //      ->name('formations.presence');

    // Keep only POST storePresence
    Route::post('formations/{formation}/presence', [FormateurFormationController::class,'storePresence'])
         ->name('formations.presence.store');
});


