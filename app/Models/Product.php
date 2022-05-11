<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $fillable = ['name', 'price', 'photo', 'surface_area_id', 'building_type_id', 'building_model_id', 'category_id'];

    // public function category()
    // {
    //     return $this->hasMany('App\Models\Category');
    // }
}
