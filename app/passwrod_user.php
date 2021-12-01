<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class passwrod_user extends Model
{
   protected $filable = ['password','user_id'];
}
