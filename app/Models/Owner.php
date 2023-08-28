<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

    // Desproteger modelo para poder insertar datos
    protected static $unguarded = true;

    public function pets(): HasMany{
        return $this->hasMany(Pet::class);
    }
}
