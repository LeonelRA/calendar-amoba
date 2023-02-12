<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{

    public static function getServicesAll($start, $end){
        $dataServicesJSON = file_get_contents(resource_path('js/components/json/services.json'));
        $services = json_decode($dataServicesJSON);
        $services = $services->services;

        $filterServices = array_filter($services, function($object) use ($start, $end) {
            $date = $object->timestamp;
            return $date >= $start && $date <= $end;
        });

        return $filterServices;
    }
}
