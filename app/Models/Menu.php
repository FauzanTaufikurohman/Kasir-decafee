<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'image',
        'desc',
        'category_id',
        'harga',
        'stok'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
