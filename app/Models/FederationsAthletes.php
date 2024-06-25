<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederationsAthletes extends Model
{
    use HasFactory;

    protected $fillable = [
        "federation_id",
        "association_id",
        "athlete_id",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
