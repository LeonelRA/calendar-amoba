<?php 

namespace App\Helpers;

use Carbon\Carbon;


final class CarbonDay {

    public static function getDayOfWeek($day) {
        switch ($day) {
            case 'sun':
                return Carbon::SUNDAY;
            case 'mon':
                return Carbon::MONDAY;
            case 'tue':
                return Carbon::TUESDAY;
            case 'wed':
                return Carbon::WEDNESDAY;
            case 'thu':
                return Carbon::THURSDAY;
            case 'fri':
                return Carbon::FRIDAY;
            case 'sat':
                return Carbon::SATURDAY;
            default:
                return false;
        }
    }

}