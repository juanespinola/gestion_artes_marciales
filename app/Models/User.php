<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserType;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // 'type' => UserType::class
    ];
    
    // protected $with = ['roles', 'permissions'];

    // public function roles(){
    //     // return $this->hasMany(Role::class);
    //     // return $this->getRoleNames()[0];
    // }
    // public function permissions(){
    //     // return $this->getPermissionsViaRoles()->pluck("name");
    //     // return $this->hasMany(Permission::class);
    // }


    // protected function type(): Attribute {
    //     return new Attribute(
    //         get: fn ($value) =>  ["admin","user"][$value],
    //     );

    // }
}
