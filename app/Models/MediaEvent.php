<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MediaEvent extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['route_file', 'type','event_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }

}
