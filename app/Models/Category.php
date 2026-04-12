<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'type_menu',
        'cat_menu',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'category_id');
    }
}
