<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AbUser extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'ab_user';

    protected $fillable = [
        'ab_name',
        'ab_email',
        'ab_password',
    ];
}
