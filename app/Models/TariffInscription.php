<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffInscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_category_id',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function entry_category() {
        // return $this->belongsTo(EntryCategory::class,  'entry_category_id', 'id');
        return $this->hasOne(EntryCategory::class, 'id', 'entry_category_id' );
    }

    public function inscriptions() {
        return $this->hasMany(Inscription::class, "tariff_inscription_id");
    }
}
