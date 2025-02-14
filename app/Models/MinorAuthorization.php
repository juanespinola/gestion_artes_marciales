<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MinorAuthorization extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'athlete_id',
        'user_id',
        'name_file',
        'route_file',
        'authorized',
        'federation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'authorized' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function athlete(){
        return $this->belongsTo(Athlete::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
