<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'shift_id',
        'kantor_id',
        'is_wfa',
    ];

    // public function User():BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function shift():BelongsTo
    {
        return $this->belongsTo(ShiftModel::class);
    }
    public function kantor():BelongsTo
    {
        return $this->belongsTo(KantorModel::class);
    }
}
