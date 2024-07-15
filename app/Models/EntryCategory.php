<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'age',
        'weight',
        'belt_id',
        'sex',
        'clothes',
        'event_id',
        'minor_category'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function belt() {
        return $this->belongsTo(Belt::class);
    }

    public function tariff_inscription()  {
        return $this->belongsTo(TariffInscription::class, 'id', 'entry_category_id');
    }

}
