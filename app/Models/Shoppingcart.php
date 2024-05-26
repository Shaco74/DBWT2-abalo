<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shoppingcart extends Model
{
    protected $table = 'ab_shoppingcart';

    public $timestamps = false;

    protected $fillable = [
        'id', 'ab_creator_id', 'ab_createdate'
    ];
}
