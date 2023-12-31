<?php

namespace App\Models;

use App\Enums\PetType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => PetType::class
    ];

    // Desproteger modelo para poder insertar datos
    protected static $unguarded = true;

    public function owner(): BelongsTo{
        return $this->belongsTo(Owner::class);
    }

    public function appointments(): HasMany{
        return $this->hasMany(Appointment::class);
    }
}
