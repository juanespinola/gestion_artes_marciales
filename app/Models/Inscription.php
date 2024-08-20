<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'event_id',
        'athlete_id',
        'tariff_inscription_id',
        'event_weight',
        'valid_weight',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'event_id',
        'tariff_inscription_id',
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
}
