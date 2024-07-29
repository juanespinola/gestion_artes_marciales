<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAutorization extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'federation_id',
        'association_id',
        'requested_by',
        'approved_by',
        'rejected_by',
        'date_request',
        'date_response',
        'request_type_id',
        'request_text',
        'response_text',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
