<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        "first_name", "last_name", "date_of_birth", "email", "phone","room", "address", "ID_front", "ID_back", "test", "test_no", "csv_date", "test_status"
    ];
}
