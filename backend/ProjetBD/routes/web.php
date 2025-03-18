<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ElectorUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ElecteurController;
use App\Models\Candidat;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\DateParrainageController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil (Bienvenue)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentification (remplace Auth::routes() pour éviter les erreurs de redirection)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Redirection après connexion
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Routes protégées (nécessitent une connexion)
Route::middleware(['auth'])->group(function () {
    // Upload de fichiers généraux
    Route::post('/upload', [UploadController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/upload', [UploadController::class, 'uploadFile'])->name('upload.file');
    Route::post('/import-csv', [UploadController::class, 'importCSV'])->name('import.csv');

    // Upload des électeurs
    Route::post('/upload-electors', [ElectorUploadController::class, 'uploadElectors'])->name('upload-electors');


    // Page d'importation
    Route::post('/import', function () {
        return view('import');
    })->name('import.page');
});
Route::get('/upload-electors', function () {
    return view('upload'); // Assure-toi que ce fichier Blade existe
})->name('upload-electors.form')->middleware('auth');


Route::post('/upload-electors', [UploadController::class, 'uploadFile'])->name('upload-electors');
Route::get('/hash-electeurs', [UploadController::class, 'showHash'])->name('hash-electeurs');
Route::get('/electeurs', [ElecteurController::class, 'index'])->name('electeurs.index');

Auth::routes();
Route::get('/choisir-role', function () {
    return view('auth.role_selection');
})->name('choisir.role');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/import', function () {
    return view('import');
})->name('import.page');

Route::get('/suivi-parrainages', [SuiviParrainageController::class, 'SuiviParrainage.php'])->name('suivi.parrainages');

Route::get('/candidats', [CandidatController::class, 'index'])->name('candidats.index');
Route::post('/candidats', [CandidatController::class, 'store'])->name('candidats.store');

Route::get('/liste-candidats', [CandidatController::class, 'listeCandidats'])->name('liste.candidats');

Route::get('/define-dates', function () {
    return view('define-dates');
})->name('define-dates');

Route::post('/update-dates', [DateParrainageController::class, 'updateDates'])->name('update-dates');


Route::get('/inscription', [ElecteurController::class, 'create'])->name('electeurs.create');
Route::post('/inscription', [ElecteurController::class, 'store'])->name('electeurs.store');
Route::post('/electeurs/store', [ElecteurController::class, 'store'])->name('electeurs.store');