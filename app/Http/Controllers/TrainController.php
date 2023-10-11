<?php

namespace App\Http\Controllers;

class TrainController extends WMAPIHelper
{
    public function getNextTrains($stationCodes = "All"): bool|string
    {
        $command = "StationPrediction.svc/json/GetPrediction/$stationCodes";
        $method = "GET";

        return $this->makeRequest("", $command, $method);
    }
}
