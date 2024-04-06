<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sport;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'sport_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function sport(){
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }

    
}
