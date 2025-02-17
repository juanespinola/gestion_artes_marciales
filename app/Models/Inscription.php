<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Inscription extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'event_id',
        'athlete_id',
        'tariff_inscription_id',
        'event_weight',
        'valid_weight',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'event_id',
        'tariff_inscription_id',
    ];

    protected $casts = [
        'valid_weight' => 'boolean',
    ];

    public function event()  {
        return $this->belongsTo(Event::class);      
    }

    public function athlete()  {
        return $this->belongsTo(Athlete::class);
    }

    public function tariff_inscription()  {
        return $this->belongsTo(TariffInscription::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
