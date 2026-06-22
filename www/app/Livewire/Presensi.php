<?php

namespace App\Livewire;

use App\Models\JadwalModel;
use App\Models\kehadiran_model;
use App\Models\KehadiranModel;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon as SupportCarbon;

class Presensi extends Component
{
    public $latitude;
    public $longitude;
    public $insideRadius = false;
    public $successMessage;
    public function render()
    {
        $jadwals = JadwalModel::where('user_id', auth:: user()->id)->first();
        $kehadiran_model = KehadiranModel::where('user_id', Auth::user()->id)
                                ->whereDate('created_at', Carbon::today())->first();
        return view('livewire.presensi', [
            'jadwals' => $jadwals,
            'insideRadius' => $this->insideRadius,
            'kehadiran_model' => $kehadiran_model,
        ]);
    }

    public function store()
    {
        $this->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

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
                    'start_latitude' => $this->latitude,
                    'start_longitude' => $this->longitude,
                    'start_time' => Carbon::now()->toTimeString(),
                    'end_time' => null,
                    'end_latitude' => null,
                    'end_longitude' => null,
                ]);
                $this->successMessage = 'Jam Masuk berhasil dicatat!';
            } else {
                // Update existing record with Jam Keluar
                $kehadiran->update([
                    'end_latitude' => $this->latitude,
                    'end_longitude' => $this->longitude,
                    'end_time' => Carbon::now()->toTimeString(),
                ]);
                $this->successMessage = 'Jam Keluar berhasil dicatat!';
            }

            return redirect('admin/kehadiran-models');

            $this->insideRadius = false;
            $this->dispatch('presensiSaved');
        }
    }
}
