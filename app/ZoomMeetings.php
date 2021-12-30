<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomMeetings extends Model
{
    protected $fillable = [
        'url','topic','start_time','start_url','phone',
    ];
}
