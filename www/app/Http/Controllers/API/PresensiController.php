<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KehadiranModel;
use App\Models\JadwalModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Store a presence record (absen masuk / pulang).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'status'    => 'required|in:masuk,pulang',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB selfie photo
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();

        // Retrieve user's schedule with office (kantor) and shift info
        $jadwal = JadwalModel::with(['kantor', 'shift'])
            ->where('user_id', $user->id)
            ->first();

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan untuk pengguna ini. Silakan hubungi admin.',
                'data'    => null,
            ], 404);
        }

        if (!$jadwal->kantor || !$jadwal->shift) {
            return response()->json([
                'success' => false,
                'message' => 'Detail kantor atau shift tidak ditemukan pada jadwal Anda.',
                'data'    => null,
            ], 404);
        }

        $today = Carbon::today()->toDateString();

        if ($request->status === 'masuk') {
            // Check if already checked in today
            $kehadiran = KehadiranModel::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->first();

            if ($kehadiran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absen masuk hari ini.',
                    'data'    => $kehadiran,
                ], 422);
            }

            // Save check-in selfie photo
            $imagePath = $request->file('image')->store('presensi/masuk', 'public');

            // Create new presence record
            $kehadiran = KehadiranModel::create([
                'user_id'           => $user->id,
                'jadwal_latitude'   => $jadwal->kantor->latitude,
                'jadwal_longitude'  => $jadwal->kantor->longitude,
                'jadwal_start_time' => $jadwal->shift->start_time,
                'jadwal_end_time'   => $jadwal->shift->end_time,
                'start_latitude'    => $request->latitude,
                'start_longitude'   => $request->longitude,
                'start_time'        => Carbon::now()->toTimeString(),
                'image_in'          => $imagePath,
                'end_time'          => null,
                'end_latitude'      => null,
                'end_longitude'     => null,
                'image_out'         => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil dicatat.',
                'data'    => [
                    'kehadiran' => $kehadiran,
                    'image_url' => asset('storage/' . $imagePath),
                ],
            ], 201);

        } else {
            // status === 'pulang'
            // Find today's presence record
            $kehadiran = KehadiranModel::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->first();

            if (!$kehadiran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan absen masuk hari ini.',
                    'data'    => null,
                ], 422);
            }

            if ($kehadiran->end_time !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absen pulang hari ini.',
                    'data'    => $kehadiran,
                ], 422);
            }

            // Save check-out selfie photo
            $imagePath = $request->file('image')->store('presensi/pulang', 'public');

            // Update today's presence record
            $kehadiran->update([
                'end_latitude'  => $request->latitude,
                'end_longitude' => $request->longitude,
                'end_time'      => Carbon::now()->toTimeString(),
                'image_out'     => $imagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absen pulang berhasil dicatat.',
                'data'    => [
                    'kehadiran' => $kehadiran,
                    'image_url' => asset('storage/' . $imagePath),
                ],
            ], 200);
        }
    }
}
