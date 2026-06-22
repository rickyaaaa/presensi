<?php

use App\Livewire\Presensi;
use Illuminate\Support\Facades\Route;
use App\Exports\KehadiranModelsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::group(['middleware' => 'auth'], function() {
    Route::get('presensi', Presensi::class)->name('presensi');
    Route::get('KehadiranModels/export',function() {
        return Excel::download(new KehadiranModelsExport, 'Kehadiran.xlsx');
    })->name('KehadiranModels.export');
});

Route::get('/login', function() {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return view('welcome');
});
