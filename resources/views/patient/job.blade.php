<?php

use App\Patient;
use Illuminate\Contracts\Session\Session;
use Symfony\Component\Process\Process;

$id= Session('patient');


$patient = Patient::where('id', $id)->first();
echo $patient->name;

?>