<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categorys';
    protected $fillable = ['name'];

    // public function product()
    // {
    //     return $this->hasMany('App\Models\Product');
    // }
}
