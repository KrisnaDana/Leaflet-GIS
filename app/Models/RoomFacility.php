<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomFacility extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class);
    }

    public function facility(): BelongsTo {
        return $this->belongsTo(Facility::class);
    }
}
