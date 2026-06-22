<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KehadiranController;
use App\Http\Controllers\API\CutiController;
use App\Http\Controllers\API\PresensiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider or bootstrap/app.php.
|
*/

Route::prefix('v1')->group(function () {
    
    // Public routes
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        
        // Presence (New Endpoint)
        Route::post('/presensi', [PresensiController::class, 'store'])->name('api.v1.presensi.store');
        
        // Leave / Cuti Endpoints (Fixed)
        Route::get('/cuti', [CutiController::class, 'index'])->name('api.v1.cuti.index');
        Route::post('/cuti', [CutiController::class, 'store'])->name('api.v1.cuti.store');

        // Other existing endpoints (Versioned)
        Route::get('/get-kehadiran-harian', [KehadiranController::class, 'getKehadiranHarian'])->name('api.v1.get_Kehadiran_Harian');
        Route::get('/get-jadwal', [KehadiranController::class, 'getJadwal'])->name('api.v1.get_jadwal');
        Route::post('/store-kehadiran', [KehadiranController::class, 'store'])->name('api.v1.store_kehadiran');
        Route::get('/get-kehadiran-bulanan-tahunan/{month}/{year}', [KehadiranController::class, 'getKehadiranBulananTahunan'])->name('api.v1.get_Kehadiran_Bulanan_Tahunan');
        Route::get('/get-image', [KehadiranController::class, 'getImage'])->name('api.v1.get_image');

        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('api.v1.user');
    });
});
