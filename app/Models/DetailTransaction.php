<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $fillable = ['transaction_id', 'user_id', 'price', 'additional_price'];
}
