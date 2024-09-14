<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MediaNew extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name_file',
        'route_file', 
        'type',
        'new_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }

    
}
