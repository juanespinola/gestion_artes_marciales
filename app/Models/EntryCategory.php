<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'name',
        // 'description',
        // 'status',
        // 'early_price',
        // 'normal_price',
        // 'event_id',

        'name',
        'age',
        'weight',
        'belt_id',
        'sex',
        'clothes',
        'event_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function belt() {
        return $this->belongsTo(Belt::class);
    }

}
