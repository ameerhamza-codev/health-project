<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tests extends Model
{
    protected $fillable = [
        'name', 'num','image','created_at',
    ];
}
