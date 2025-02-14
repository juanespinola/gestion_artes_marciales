<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Belt extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'color',
        'color_hexadecimal',
        'federation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function entry_category() {
        return $this->belongsTo(Belt::class, 'belt_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
