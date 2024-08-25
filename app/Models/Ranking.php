<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'athlete_id',
        'event_id',
        'entry_category_id',
        "position",
        "points",
        "victories",
        'defeats',
    ];


    public static function getRankingByEvent($event_id){

    }


}
