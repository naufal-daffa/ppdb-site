<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicantSideController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\RegistrasionWaveController;
use App\Http\Controllers\SkillFieldController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Models\Applicant;
use App\Models\RegistrationWave;
use App\Models\SkillField;
use Illuminate\Support\Facades\App;
// use App\Models\RegistrationWave;
use Illuminate\Support\Facades\Mail;
// use App\Models\SkillField;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('isGuest');

Route::post('/login/auth', [UserController::class, 'login'])->name('login.auth')->middleware('isGuest');

Route::get('/signup', [RegisController::class, 'index'])->name('signup')->middleware('isGuest');
Route::post('/signup/store', [ApplicantController::class, 'store'])->name('signup.store')->middleware('isGuest');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');


    Route::prefix('/skill-fields')->name('skill-fields.')->group(function () {
        Route::get('/', [SkillFieldController::class, 'index'])->name('index');
        Route::get('/create', [SkillFieldController::class, 'create'])->name('create');
        Route::post('/store', [SkillFieldController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SkillFieldController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SkillFieldController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SkillFieldController::class, 'destroy'])->name('delete');
        Route::patch('/restore/{id}', [SkillFieldController::class, 'restore'])->name('restore');
        Route::get('/trash', [SkillFieldController::class, 'trash'])->name('trash');
        Route::delete('/delete-permanent/{id}', [SkillFieldController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatable', [SkillFieldController::class, 'dataForDatatables'])->name('datatables');
        Route::get('/export', [SkillFieldController::class, 'export'])->name('export');
    });


    Route::prefix('/majors')->name('majors.')->group(function () {
        Route::get('/', [MajorController::class, 'index'])->name('index');
        Route::get('/create', [MajorController::class, 'create'])->name('create');
        Route::post('/store', [MajorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MajorController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MajorController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [MajorController::class, 'destroy'])->name('delete');
        Route::patch('/restore/{id}', [MajorController::class, 'restore'])->name('restore');
        Route::get('/trash', [MajorController::class, 'trash'])->name('trash');
        Route::delete('/delete-permanent/{id}', [MajorController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatable', [MajorController::class, 'dataForDatatables'])->name('datatables');
        Route::get('/export', [MajorController::class, 'export'])->name('export');
    });


    Route::prefix('/registrasion-waves')->name('registrasion-waves.')->group(function () {
        Route::get('/', [RegistrasionWaveController::class, 'index'])->name('index');
        Route::get('/create', [RegistrasionWaveController::class, 'create'])->name('create');
        Route::post('/store', [RegistrasionWaveController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RegistrasionWaveController::class, 'edit'])->name('edit');
        Route::patch('/patch/{id}', [RegistrasionWaveController::class, 'patch'])->name('patch');
        Route::put('/update/{id}', [RegistrasionWaveController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RegistrasionWaveController::class, 'destroy'])->name('delete');
        Route::patch('/restore/{id}', [RegistrasionWaveController::class, 'restore'])->name('restore');
        Route::get('/trash', [RegistrasionWaveController::class, 'trash'])->name('trash');
        Route::delete('/delete-permanent/{id}', [RegistrasionWaveController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatable', [RegistrasionWaveController::class, 'dataForDatatables'])->name('datatables');
        Route::get('/export', [RegistrasionWaveController::class, 'export'])->name('export');
    });


    Route::prefix('/applicants')->name('applicants.')->group(function () {
        Route::get('/', [ApplicantController::class, 'index'])->name('index');
        Route::get('/create', [ApplicantController::class, 'create'])->name('create');
        Route::post('/store', [ApplicantController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ApplicantController::class, 'edit'])->name('edit');
        Route::patch('/patch/{id}', [ApplicantController::class, 'patch'])->name('patch');
        Route::put('/update/{id}', [ApplicantController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ApplicantController::class, 'destroy'])->name('delete');
        Route::patch('/restore/{id}', [ApplicantController::class, 'restore'])->name('restore');
        Route::get('/trash', [ApplicantController::class, 'trash'])->name('trash');
        Route::delete('/delete-permanent/{id}', [ApplicantController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatable', [ApplicantController::class, 'dataForDatatables'])->name('datatables');
        Route::get('/export', [ApplicantController::class, 'export'])->name('export');
    });


    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/patch/{id}', [UserController::class, 'patch'])->name('patch');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatable', [UserController::class, 'dataForDatatables'])->name('datatables');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });


    Route::prefix('/staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/store', [StaffController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('edit');
        Route::patch('/patch/{id}', [StaffController::class, 'patch'])->name('patch');
        Route::put('/update/{id}', [StaffController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [StaffController::class, 'destroy'])->name('delete');
        Route::patch('/restore/{id}', [StaffController::class, 'restore'])->name('restore');
        Route::get('/trash', [StaffController::class, 'trash'])->name('trash');
        Route::delete('/delete-permanent/{id}', [StaffController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatable', [StaffController::class, 'dataForDatatables'])->name('datatables');
        Route::get('/export', [StaffController::class, 'export'])->name('export');
    });
});


Route::middleware('isStaff')->prefix('/staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
    Route::prefix('/applicants')->name('applicants.')->group(function(){
        Route::get('/', [ApplicantController::class, 'indexStaff'])->name('home');
        Route::get('/datatable', [ApplicantController::class, 'dataForDatatablesStaff'])->name('datatables');
        Route::patch('/dashboard/terima/{id}', [ApplicantController::class, 'diterima'])->name('terima');
        Route::patch('/dashboard/tolak/{id}', [ApplicantController::class, 'ditolak'])->name('tolak');
    });
    Route::prefix('/documents')->name('documents.')->group(function() {
        Route::get('/', DocumentController::class, 'index')->name('index');
    });
});

Route::middleware('isApplicant')->prefix('/applicants')->name('applicants.')->group(function () {

    Route::get('/index', [ApplicantController::class, 'indexPendaftar'])->name('index');
    Route::post('/upload/{id}', [ApplicantController::class, 'uploadBuktiPembayaran'])->name('upload');

    Route::prefix('/documents')->name('documents.')->group(function(){
        Route::get('/', [ApplicantSideController::class, 'index'])->name('index');
        Route::post('/store', [ApplicantSideController::class, 'store'])->name('store');
        // Route::put('/store', [ApplicantSideController::class, 'store'])->name('store');
    });
});
