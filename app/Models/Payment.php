<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'inscription_id',
        'membership_id',
        'payment_gateway',
        'json_response',
        'json_request',
        'json_rollback',
        'status',
        'federation_id',
        'association_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
