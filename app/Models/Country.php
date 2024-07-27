<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function city($country_id) {
        return $this->belongsTo(Country::class);
    }
}
