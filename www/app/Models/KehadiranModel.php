<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KehadiranModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'jadwal_latitude',
        'jadwal_longitude',
        'jadwal_start_time',
        'jadwal_end_time',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'start_time',
        'end_time',
        'image_in',
        'image_out'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isTerlambat()
    {
        $jadwal_start_time = \Carbon\Carbon::parse($this->jadwal_start_time);
        $start_time = \Carbon\Carbon::parse($this->start_time);

        return $start_time->greaterThan($jadwal_start_time);
    }

    public function durasiKerja()
    {
        $start_time = \Carbon\Carbon::parse($this->start_time);
        $end_time = \Carbon\Carbon::parse($this->end_time);

        $duration = $start_time->diff($end_time);

        $hours = $duration->h;
        $minutes = $duration->i;

        return "{$hours} jam {$minutes} menit";
    }
}
