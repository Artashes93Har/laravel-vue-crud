<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'status',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    protected $casts = [
        'created_at' => 'date:Y-m-d'
    ];
}
