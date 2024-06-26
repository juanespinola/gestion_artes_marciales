<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaEvent extends Model
{
    use HasFactory;

    protected $fillable = ['route_file', 'type','event_id'];

}
