<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ladumor\OneSignal\OneSignal;

class CalendlyController extends Controller
{
    $fields['include_player_ids'] = ['xxxxxxxx-xxxx-xxx-xxxx-yyyyy']
$notificationMsg = 'Hello!! A tiny web push notification.!'
OneSignal::sendPush($fields, $notificationMsg);
}
