<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   // Product.php
protected $fillable = [
    'name', 'description', 'quantity', 'price', 'min_quantity', 'category_id', 'image'
];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }
}
