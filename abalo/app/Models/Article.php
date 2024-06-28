<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'ab_article';

    public $timestamps = false;

    protected $fillable = ['id', 'ab_name', 'ab_price', 'ab_discount', 'ab_description', 'ab_creator_id', 'ab_createdate'];

}
