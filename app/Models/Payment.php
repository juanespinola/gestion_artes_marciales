<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'inscription_id',
        'membership_id',
        'payment_gateway',
        'json_response',
        'json_request',
        'json_rollback',
        'status',
        'federation_id',
        'association_id',
        'athlete_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function membership()  {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }

    public function inscription()  {
        return $this->belongsTo(Inscription::class, 'inscription_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
