<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Sanction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'athlete_id',
        'description',
        'comments',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }

    public function athlete(){
        return $this->belongsTo(Athlete::class);
    }
}
