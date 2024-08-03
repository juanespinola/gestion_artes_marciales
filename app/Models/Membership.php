<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'number_fee',
        'start_date_fee',
        'end_date_fee',
        'status',
        'amount_fee',
        'payment_date_fee',
        'type_membership_id',
        'athlete_id',
        'federation_id',
        'association_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
