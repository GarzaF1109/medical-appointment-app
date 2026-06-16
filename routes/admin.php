<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\InsuranceController;

Route::get('/', function () {
    return view ('admin.dashboard');
})->name('dashboard');

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('patients', PatientController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('appointments', AppointmentController::class);
Route::get('appointments/{appointment}/consultation', [AppointmentController::class, 'consultation'])->name('appointments.consultation');
Route::get('doctors/{doctor}/schedules', function (\App\Models\Doctor $doctor) {
    $doctor->load('user', 'speciality');
    return view('admin.doctors.schedules', compact('doctor'));
})->name('doctors.schedules');
Route::resource('insurances', InsuranceController::class);