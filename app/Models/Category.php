<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'status',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    protected $casts = [
        'created_at' => 'date:Y-m-d'
    ];
}
