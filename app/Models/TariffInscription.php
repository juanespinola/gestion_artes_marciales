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
        return $this->hasOne(EntryCategory::class, 'id', 'entry_category_id');
    }
}
