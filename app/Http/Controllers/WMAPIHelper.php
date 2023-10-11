<?php
namespace App\Http\Controllers;

class WMAPIHelper extends Controller
{
    protected $primaryAPIKey;

    protected $secondaryAPIKey;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->primaryAPIKey = getenv('WMAPI_PRIMARY_API_KEY');
        $this->secondaryAPIKey = getenv('WMAPI_SECONDARY_API_KAY');
    }

    //generic request function to be used by subclasses that manage different API interactions
    public function makeRequest($body = '', $command = '', $method = '')
    {

//      $value = Cache::get(requesterIP);
//      check here if we've have a recent request from this IP and the timestamp
//      so we can decide to delay or deny the request in order to comply with rate limits
//      assuming that if we're hitting a rate limit it's because a user is doing something inappropriate
//      if we hit the limit from multiple users then that's more of a scaling problem
//      and we need to look into alternative solutions
//      if there is a cache'd result but the timestamp is old, clear that cache entry
        $headers = [
            'Content-Type: application/json',
            "api_key: $this->primaryAPIKey",
        ];

        $url = "https://api.wmata.com/$command";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $curlResult = curl_exec($ch);
        $curlError = curl_errno($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpStatus !== 200) {
            //log error and return
            return $curlError;
        }
//      Cache::set(requesterIP, timestamp);
//      set a cache value of the requester with a timestamp so we can check above

        return $curlResult;
    }

    public function validateAPIKey()
    {
        $command = 'Misc/Validate';
        $method = 'GET';

        if ($this->makeRequest("", $command, $method)) {
            return true;
        } else {
            return false;
        }
    }


}
