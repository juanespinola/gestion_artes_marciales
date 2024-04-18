<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'location_id',
        'initial_date',
        'final_date',
        'event_type_id',
        'event_status_id',
        'inscription_fee',
        'total_participants',
        'available_slots',
        'created_user_id',
        'updated_user_id',
        'federation_id',
        'association_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $dates = ['initial_date', 'final_date'];
}
