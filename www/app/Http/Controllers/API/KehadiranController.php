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
                                ->whereDate('start_time', $today)
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' =>'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $jadwal = JadwalModel::where('user_id', Auth::user()->id)->first();

        if ($jadwal) {
            $kehadiran = KehadiranModel::where('user_id', Auth::user()->id)
                                ->whereDate('created_at', Carbon::today())->first();
            if (!$kehadiran) {
                // Create new attendance record (Jam Masuk)
                KehadiranModel::create([
                    'user_id' => Auth::user()->id,
                    'jadwal_latitude' => $jadwal->kantor->latitude,
                    'jadwal_longitude' => $jadwal->kantor->longitude,
                    'jadwal_start_time' => $jadwal->shift->start_time,
                    'jadwal_end_time' => $jadwal->shift->end_time,
                    'start_latitude' => $request->latitude,
                    'start_longitude' => $request->longitude,
                    'start_time' => Carbon::now()->toTimeString(),
                    'end_time' => null,
                    'end_latitude' => null,
                    'end_longitude' => null,
                ]);
            } else {
                // Update existing record with Jam Keluar
                $kehadiran->update([
                    'end_latitude' => $request->latitude,
                    'end_longitude' => $request->longitude,
                    'end_time' => Carbon::now()->toTimeString(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Kehadiran berhasil disimpan',
                'data' => $kehadiran
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Jadwal tidak ditemukan untuk pengguna ini'
            ], 404);
        }
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
