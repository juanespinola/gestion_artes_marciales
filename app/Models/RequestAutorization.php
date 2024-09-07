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
        'status',
        'athlete_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function association() {
        return $this->belongsTo(Association::class);
    }

    public function typerequest() {
        return $this->belongsTo(TypeRequest::class, 'request_type_id', 'id');
    }

}
