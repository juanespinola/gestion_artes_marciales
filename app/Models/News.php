<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MediaNew;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'status',
        'created_user_id',
        'updated_user_id',
        'federation_id',
        'association_id',
        // 'new_category_id',
        'created_at',
    ];

    protected $hidden = [
        'federation_id',
        'association_id',
        'new_category_id',
        // 'created_at',
        'updated_at',
        'created_user_id',
        'updated_user_id',
    ];


    public function category_new() {
        return $this->belongsTo(CategoryNew::class, 'new_category_id', 'id');      
    }

    public function media_new_list() {
        return $this->belongsTo(MediaNew::class, 'id', 'new_id')->where('type', 'banner_new_list');      
    }

    public function media_new_detail() {
        return $this->belongsTo(MediaNew::class, 'id', 'new_id')->where('type', 'banner_new_detail');      
    }


}
