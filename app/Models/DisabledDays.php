<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisabledDays extends Model
{
    public static function getDisabledDays($start, $end, $calendarId){
        $daysDisabledJSON = file_get_contents(resource_path('js/components/json/calendar_days_disabled.json'));
        $daysDisabled = json_decode($daysDisabledJSON);
        $daysDisabled = $daysDisabled->calendar_days_disabled;

        $filterDaysDisabled = array_filter($daysDisabled, function($object) use ($start, $end, $calendarId) {
            $date = $object->day;

            if($calendarId !== null && $calendarId > 0){
                return $date >= $start && $date <= $end && $object->calendar_id == $calendarId;
            }
            return $date >= $start && $date <= $end;
        });

        return $filterDaysDisabled;
    }
}
