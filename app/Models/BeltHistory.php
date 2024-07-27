<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeltHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'belt_id',
        'athlete_id',
        'federation_id',
        'achieved',
        'promoted_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function belt() {
        return $this->belongsTo(Belt::class);
    }
}
