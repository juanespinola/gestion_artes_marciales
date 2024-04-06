<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Association;

class GroupCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_id',
        'group_category',
        // 'description',
        'initial_value',
        'final_value',
        'federation_id',
        'association_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function federation(){
        return $this->hasOne(Federation::class, 'id', 'federation_id');
    }

    public function association(){
        return $this->hasOne(Association::class, 'id', 'association_id');
    }
}
