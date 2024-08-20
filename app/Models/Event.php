<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\MediaEvent;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'location_id',
        'initial_date',
        'final_date',
        'initial_time',
        'final_time',
        'event_type_id',
        'event_status_id',
        'inscription_fee',
        'total_participants',
        'available_slots',
        'quantity_quadrilateral',
        'created_user_id',
        'updated_user_id',
        'federation_id',
        'association_id',
        'content',
        'introduction'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'location_id',
        'federation_id',
        'association_id',
        'event_type_id',
        'event_status_id',
    ];

    protected $casts = [
        'initial_date'  => 'date:Y-m-d',
        'final_date' => 'date:Y-m-d',
    ];

    // protected $dateFormat = 'U';

    public function location() {
        return $this->belongsTo(Location::class);
    }
    
    public function media_event() {
        return $this->hasMany(MediaEvent::class);
    }

    public function federation() {
        return $this->belongsTo(Federation::class);
    }

    public function association() {
        return $this->belongsTo(Association::class);
    }

    public function status_event() {
        return $this->belongsTo(StatusEvent::class);
    }
    public function type_event() {
        return $this->belongsTo(TypesEvent::class);
    }

    public function matchBrackets() {
        return $this->hasMany(MatchBracket::class, 'event_id');
    }
}
