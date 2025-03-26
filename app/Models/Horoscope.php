<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model
{
    protected $fillable = ['sign', 'lang', 'time', 'prediction', 'date'];
}
