<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Association extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'description',
        'federation_id',
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


    public function federation() {
        return $this->belongsTo(Federation::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }

}
