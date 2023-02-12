<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisabledDays;
use App\Models\Reservations;
use App\Models\Services;
use App\Models\Calendars;
use Carbon\Carbon;
use App\Helpers\CarbonDay;

class CalendarController extends Controller
{
    public $controller;

    public function __construct()
    {
        $this->controller = new Controller;
    }

    public function getCalendars(){

        $allCalendars= Calendars::getAll();

        return $this->controller->responseApi(true, ['type' => 'success', 'content' => "Done"], $allCalendars);
    }

    public function calendar(Request $request)
    {
        $userId = 35;
        $userPlanId = 52;

        $calendarId     = $request->data['calendarId'] ?? null;
        $year           = $request->data['startYear']; 
        $month          = $request->data['startMonht']; 
        $monthEnd       = $request->data['endMonht'] ?? $month;
        $yearEnd        = $request->data['endYear'] ?? $year; 
        $monthEndStatic = $request->data['endMonht'];
        $daysDisabled    = $request->data['daysDisabled'];

        if($year < $yearEnd && $month > $monthEnd){
            $monthEnd = 12;
        }

        $arrayMonths = [];

        for($y = $year; $y <= $yearEnd; $y++){
            for($m = $month; $m <= $monthEnd; $m++){

                if ($y < $yearEnd) {
                    $month = 1;
                    $monthEnd = 12; 
                }

                if ($y == $yearEnd && $year !== $yearEnd) {
                    $monthEnd = $monthEndStatic; 
                    $month = 1;
                }

                $start = Carbon::createFromDate($y, $m, 1)->startOfWeek();
                $end = Carbon::createFromDate($y, $m, 1)->endOfMonth()->endOfWeek();

                if ($start->dayOfWeek !== Carbon::SUNDAY) {
                    $start->previous(Carbon::SUNDAY);
                }

                $filterDaysDisabled= DisabledDays::getDisabledDays($start, $end, $calendarId);
                $filterDataReservation = Reservations::getReservations($start, $end, $userPlanId);
                $getServicesAll = Services::getServicesAll($start, $end);

                $days = [];
                while ($start <= $end) {

                    $dayDisabled = array_reduce($filterDaysDisabled, function($carry, $object) use($start){
                        return ($start->format('Y-m-d') == substr($object->day, 0, 10)) ?  true : $carry;
                    }, false);

                    $reservation = array_reduce($filterDataReservation, function($carry, $object) use($start){
                        return ($start->format('Y-m-d') == substr($object->reservation_start, 0, 10)) ?  true : $carry;
                    }, false);

                    $services = array_reduce($getServicesAll, function($carry, $object) use($start){
                        $toDay = ($start->format('Y-m-d') == substr($object->timestamp, 0, 10)) ?  true : false;
                        return ($toDay && $object->capacity == $object->confirmed_pax_count)  ?  true : $carry;
                    }, false);

                    $isWorkingDay = true;
                    foreach ($daysDisabled as $day) {
                        if ($start->dayOfWeek === CarbonDay::getDayOfWeek($day)) {
                            $isWorkingDay = false;
                            break;
                        }
                    }

                    array_push($days, [
                        'day'   => (int) $start->format('d'),
                        'month' => (int) $start->format('m'),
                        'year'  => (int) $start->format('Y'),
                        'is_working_day' => $isWorkingDay,
                        'day_disabled'   => $dayDisabled,
                        'reservation'    => $reservation,
                        'full_capacity'  => $services
                    ]);

                    $start->addDay();
                }

                $arrayMonths[] = $days;
        
            }
        }

        return $this->controller->responseApi(true, ['type' => 'success', 'content' => "Done"], $arrayMonths);
    }

    public function routes(){
        $RoutesJSON = file_get_contents(resource_path('js/components/json/routes.json'));
        $routes = json_decode($RoutesJSON);

        $RoutesDataJSON = file_get_contents(resource_path('js/components/json/route_data.json'));
        $routesData = json_decode($RoutesDataJSON);

        $routesData = $routesData->routes_data;
        $dataRoutes= array_slice($routes->routes, 0, 20);

        $routes = [];

        foreach($dataRoutes as $routeParent){
            foreach($routesData as $routeData){
                if($routeData->route_id == $routeParent->id){
                    $routes[$routeParent->id][] = $routeData;
                    $routes[$routeParent->id][] = $routeParent;
                }
            }
        }

        return $this->controller->responseApi(true, ['type' => 'success', 'content' => "Done"], $routes);
    }


    
}

