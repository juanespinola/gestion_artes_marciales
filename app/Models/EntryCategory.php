<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EntryCategory extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'name',
        'min_age',
        'max_age',
        'min_weight',
        'max_weight',
        'belt_id',
        'gender',
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

    public function tariff_inscription() {
        return $this->hasOne(TariffInscription::class, 'entry_category_id');
    }

    public function matchBracket() {
        return $this->hasMany(MatchBracket::class, 'entry_category_id');
    }

    public function inscriptions() {
        return $this->hasMany(Inscription::class);
    }    

    public function ranking() {
        return $this->hasMany(Ranking::class);
    }

    public function event() {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }    

    public static function ringMatMatchBracket($event_id) {
        return DB::table('entry_categories')
            ->select('entry_categories.name', 'match_brackets.quadrilateral', 'entry_categories.gender', DB::raw('count(match_brackets.id) as quantity_match'))
            ->join('match_brackets', 'entry_categories.id', '=', 'match_brackets.entry_category_id')
            ->groupBy(['entry_categories.name', 'match_brackets.quadrilateral', 'entry_categories.gender'])
            ->orderBy('match_brackets.quadrilateral')
            ->where('entry_categories.event_id', $event_id)
            ->get();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }

}
