<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function hotels(): BelongsTo {
        return $this->belongsTo(Hotel::class);
    }

    public function room_facilities(): HasMany {
        return $this->hasMany(RoomFacility::class);
    }
}
