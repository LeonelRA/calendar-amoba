<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{

    public static function getReservations($start, $end, $userPlanId){
        $dataReservationJSON = file_get_contents(resource_path('js/components/json/reservations.json'));
        $reservations = json_decode($dataReservationJSON);
        $reservations = $reservations->reservations;

        $filterDataReservation = array_filter($reservations, function($object) use ($start, $end, $userPlanId) {
            $toDay = $object->reservation_start >= $start && $object->reservation_start <= $end;
            return ($toDay && $object->user_plan_id == $userPlanId);
        });

        return $filterDataReservation;
    }
}
