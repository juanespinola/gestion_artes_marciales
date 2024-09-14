<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TariffInscription extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'entry_category_id',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function entry_category() {
        return $this->belongsTo(EntryCategory::class,  'entry_category_id');
    }

    public function inscriptions() {
        return $this->hasMany(Inscription::class, "tariff_inscription_id");
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
