<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Federation;
use App\Models\Association;
use App\Models\FederationsAthletes;


class Athlete extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        // "federation_id",
        // "association_id",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // protected $with = ['federation'];
    public function federation($federation_id) {
        return $this->belongsToMany(Federation::class, FederationsAthletes::class, 'athlete_id', 'federation_id')
                    ->wherePivot('federation_id', $federation_id);
    }

    // public function federation($federation_id){     
    //     return $this->belongsToMany(Federation::class, FederationsAthletes::class, 'athlete_id', 'federation_id')->where('federation_id', $federation_id);
    // }
}
