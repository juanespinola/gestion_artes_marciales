<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BeltHistory extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
