<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class City extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'description',
        'status',
        'country_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
    

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    
    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
