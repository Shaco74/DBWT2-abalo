<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchArticle extends Model
{
    protected $table = 'ab_article';

    public $timestamps = false;

    protected $fillable = ['ab_name', 'ab_price', 'ab_description', 'ab_creator_id', 'ab_createdate'];

}
