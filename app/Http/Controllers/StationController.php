<?php

namespace App\Http\Controllers;

class StationController extends WMAPIHelper
{
    public function displayThings(){
        echo $this->primaryAPIKey.$this->secondaryAPIKey;
    }

    public function getStationList($lineColor = ""): bool|string
    {
//      $value = Cache::get(stationList);
//      check if we've cache the results of this recently and if so use that for the result instead of a new request
        $command = "Rail.svc/json/jStations?LineCode=$lineColor";
        $method = "GET";
//      set cache with timestamp before returning result
        return $this->makeRequest("",$command, $method);
    }

    public function getStationTimes($stationCode = ""): bool|string
    {

        $command = "Rail.svc/json/jStationTimes?StationCode=$stationCode";
        $method = "GET";

        return $this->makeRequest("", $command, $method);
    }
}
