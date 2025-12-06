<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['product_id', 'title', 'message', 'type', 'read'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
