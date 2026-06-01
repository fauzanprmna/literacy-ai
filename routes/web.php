<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\SettingsController;

// CRUD Admin
use App\Http\Controllers\ModulController;
use App\Http\Controllers\AnswerTemplateController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// Locale switching
Route::get('/locale/{locale}', [LocaleController::class, 'setLocale'])->name('locale.set');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/language', [SettingsController::class, 'updateLanguage'])->name('settings.updateLanguage');

    // pengukuran questionnaire
    Route::get('/literacy-ai/pengukuran', [PengukuranController::class, 'show'])->name('pengukuran.index');

    // Likert Scale Flow
    Route::get('/literacy-ai/pengukuran/info-likert', [PengukuranController::class, 'infoLikert'])->name('pengukuran.info.likert');
    Route::get('/literacy-ai/pengukuran/kuesioner-likert', [PengukuranController::class, 'kuesionerLikert'])->name('pengukuran.kuesioner.likert');
    Route::post('/literacy-ai/pengukuran/store-likert', [PengukuranController::class, 'storeLikert'])->name('pengukuran.store.likert');

    // Multiple Choice Flow
    Route::get('/literacy-ai/pengukuran/info-pilihan-ganda', [PengukuranController::class, 'infoPilihanGanda'])->name('pengukuran.info.pilihan_ganda');
    Route::get('/literacy-ai/pengukuran/kuesioner-pilihan-ganda', [PengukuranController::class, 'kuesionerPilihanGanda'])->name('pengukuran.kuesioner.multiple_choice');
    Route::post('/literacy-ai/pengukuran/store-pilihan-ganda', [PengukuranController::class, 'storePilihanGanda'])->name('pengukuran.store.multiple_choice');

    // Legacy routes (kept for backward compatibility)
    Route::get('/literacy-ai/pengukuran/hasil', [PengukuranController::class, 'hasil'])->name('pengukuran.hasil');



    Route::resource('modul', ModulController::class);
    Route::get('/content/{content}', [ModulController::class, 'showContent'])->name('modul.showContent');
    Route::resource('category', CategoryController::class);
    Route::get('/modul/category/{category}', [ModulController::class, 'showByCategory'])->name('modul.by-category');
    Route::resource('answer-template', AnswerTemplateController::class);
    Route::resource('question', QuestionController::class);

    Route::get('user/mahasiswa', [UserController::class, 'mahasiswaIndex'])->name('user.mahasiswa.index');
    Route::get('user/mahasiswa/create', [UserController::class, 'createMahasiswa'])->name('user.mahasiswa.create');
    Route::post('user/mahasiswa', [UserController::class, 'storeMahasiswa'])->name('user.mahasiswa.store');

    Route::get('user/dosen', [UserController::class, 'dosenIndex'])->name('user.dosen.index');
    Route::get('user/dosen/create', [UserController::class, 'createDosen'])->name('user.dosen.create');
    Route::post('user/dosen', [UserController::class, 'storeDosen'])->name('user.dosen.store');

    Route::resource('user', UserController::class);

    // User import/export
    Route::get('/users/import', [App\Http\Controllers\UserImportExportController::class, 'importForm'])->name('users.import.form');
    Route::post('/users/import', [App\Http\Controllers\UserImportExportController::class, 'import'])->name('users.import');
    Route::get('/users/export', [App\Http\Controllers\UserImportExportController::class, 'export'])->name('users.export');

    // Mahasiswa import/export
    Route::get('/mahasiswa/import', [App\Http\Controllers\UserImportExportController::class, 'mahasiswaImportForm'])->name('mahasiswa.import.form');
    Route::post('/mahasiswa/import', [App\Http\Controllers\UserImportExportController::class, 'mahasiswaImport'])->name('mahasiswa.import');
    Route::get('/mahasiswa/export', [App\Http\Controllers\UserImportExportController::class, 'mahasiswaExport'])->name('mahasiswa.export');

    // Dosen import/export
    Route::get('/dosen/import', [App\Http\Controllers\UserImportExportController::class, 'dosenImportForm'])->name('dosen.import.form');
    Route::post('/dosen/import', [App\Http\Controllers\UserImportExportController::class, 'dosenImport'])->name('dosen.import');
    Route::get('/dosen/export', [App\Http\Controllers\UserImportExportController::class, 'dosenExport'])->name('dosen.export');
});
Route::get('/manifest-check', function () {
    return response()->json(
        json_decode(file_get_contents(public_path('build/manifest.json')), true)
    );
});
