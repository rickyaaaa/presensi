<?php

namespace App\Exports;

use App\Models\KehadiranModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Schema;

class KehadiranModelsExport implements FromQuery, WithHeadings
{
    public function query ()
    {
        return KehadiranModel::query()
            ->join('users', 'kehadiran_models.user_id', '=', 'users.id')
            ->select([
                'users.name as Nama Pegawai',
                'users.email as Email',
                'kehadiran_models.jadwal_latitude as Jadwal Latitude',
                'kehadiran_models.jadwal_longitude as Jadwal Longitude',
                'kehadiran_models.jadwal_start_time as Jadwal Start Time',
                'kehadiran_models.jadwal_end_time as Jadwal End Time',
                'kehadiran_models.start_latitude as Start Latitude',
                'kehadiran_models.start_longitude as Start Longitude',
                'kehadiran_models.start_time as Start Time',
                'kehadiran_models.end_time as End Time',
                'kehadiran_models.end_latitude as End Latitude',
                'kehadiran_models.end_longitude as End Longitude',
            ]);
    }

    public function headings(): array
    {
        return ([
            'Username',
            'Email',
            'Jadwal Latitude',
            'Jadwal Longitude',
            'Jadwal Start Time',
            'Jadwal End Time',
            'Start Latitude',
            'Start Longitude',
            'Start Time',
            'End Time',
            'End Latitude',
            'End Longitude',


        ]);
    }
}
