<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Federation extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'id',
        'description',
        'status',
        'email',
        'phone_number',
        'president',
        'vice_president',
        'treasurer',
        'facebook',
        'whatsapp',
        'twitter',
        'instagram',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function association() {
        return $this->belongsTo(Association::class, 'id', 'federation_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}


