<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Belt extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'color',
        'federation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function entry_category() {
        return $this->belongsTo(Belt::class, 'belt_id', 'id');
    }
}
