<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price'];

    public function Categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}
