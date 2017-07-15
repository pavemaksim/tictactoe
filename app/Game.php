<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Game extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['board'];
}
