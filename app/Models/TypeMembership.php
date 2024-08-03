<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'price',
        'number_fee',
        'federation_id',
        'association_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
