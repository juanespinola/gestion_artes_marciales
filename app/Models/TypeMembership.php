<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TypeMembership extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'description',
        'price',
        'total_number_fee',
        'federation_id',
        'association_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
