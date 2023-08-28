<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    // Desproteger modelo para poder insertar datos
    protected static $unguarded = true;

    protected $casts = [
        'status' => AppointmentStatus::class
    ];

    public function pet(): BelongsTo{
        return $this->belongsTo(Pet::class);
    }

}

