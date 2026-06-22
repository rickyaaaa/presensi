<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KehadiranModel;
use App\Models\JadwalModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    public function getKehadiranHarian()
    {
        $userId = auth()->user()->id;
        $today = now()->toDateString();
        $currenMonth = now()->month;

        $KehadiranHarian = KehadiranModel::select('start_time', 'end_time')
                                ->where('user_id', $userId)
                                ->whereDate('created_at', $today)
                                ->first();
        $KehadiranBulanan = KehadiranModel::select('start_time','end_time', 'created_at')
                                ->where('user_id', $userId)
                                ->whereMonth('created_at', $currenMonth)
                                ->get()
                                ->map(function ($KehadiranModel) {
                                    return [
                                        'start_time' =>$KehadiranModel->start_time,
                                        'end_time' => $KehadiranModel->end_time,
                                        'created_at' => $KehadiranModel->created_at->toDateString(),
                                    ];
                                });
        return response()->json([
            'success' => true,
            'data' => [
                'kehadiran_harian' => $KehadiranHarian,
                'kehadiran_bulanan' => $KehadiranBulanan,
            ],
            'message' => 'Data Kehadiran Harian berhasil diambil',
        ]);
    }

    public function getJadwal()
    {
        $Jadwal = JadwalModel::with(['kantor', 'shift'])
                                ->where('user_id', auth()->user()->id)
                                ->first();

        if ($Jadwal == null){
            return response()->json([
                'success' => false,
                'message' => 'User belum memiliki jadwal, silakan hubungi admin',
                'data' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Jadwal berhasil diambil',
            'data' => $Jadwal,
        ]);
    }

    public function getKehadiranBulananTahunan($month, $year)
    {
        $validator = Validator::make(['month' => $month, 'year' => $year], [
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2020|max:'. Carbon::now()->year,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $Jadwal = JadwalModel::where('user_id', Auth::user()->id)->first();

        if ($Jadwal == null){
            return response()->json([
                'success' => false,
                'message' => 'User belum memiliki jadwal, silakan hubungi admin',
                'data' => null
            ]);
        }

        $userId = auth()->user()->id;
        $KehadiranList = KehadiranModel::select('start_time','end_time', 'created_at')
                                ->where('user_id', $userId)
                                ->whereMonth('created_at', $month)
                                ->whereYear('created_at', $year)
                                ->get()
                                ->map(function ($KehadiranModel) {
                                    return [
                                        'start_time' =>$KehadiranModel->start_time,
                                        'end_time' => $KehadiranModel->end_time,
                                        'created_at' => $KehadiranModel->created_at->toDateString(),
                                    ];
                                });

        return response()->json([
            'success' => true,
            'data' => $KehadiranList,
            'message' => 'Data Kehadiran berhasil diambil Bulan dan Tahun',
        ]);
    }

    public function getImage()
    {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'data' => $user->image_url,
            'message' => 'Data Image berhasil diambil',
        ]);
    }
}
