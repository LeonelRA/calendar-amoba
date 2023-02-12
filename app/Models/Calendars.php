<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendars extends Model
{
    public static function getAll(){
        $calendarsJSON = file_get_contents(resource_path('js/components/json/calendar.json'));
        $calendars = json_decode($calendarsJSON);
        $calendars = $calendars->calendar;

        return $calendars;
    }
}
