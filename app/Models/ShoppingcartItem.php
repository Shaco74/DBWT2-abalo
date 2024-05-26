<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingcartItem extends Model
{
    protected $table = 'ab_shoppingcart_item';


    public $timestamps = false;

    protected $fillable = [
        'id', 'ab_shoppingcart_id', 'ab_article_id', 'ab_createdate'
    ];
}
