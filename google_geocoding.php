<?php
function google_geocoding($addr, $lang){
    $addr = urlencode($addr);
    $qURL = "http://maps.googleapis.com/maps/api/geocode/json?address=$addr&sensor=false&language=$lang";
    $ch = curl_init($qURL);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);  
    $res = curl_exec($ch);  
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode != 200){
        $errNo = curl_errno($ch);
        $err = curl_error($ch);
        error_log("Request to Google geocoding Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$res");
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    $res = json_decode($res, true);
    if(!isset($res['results'][0])){
        return false;
    }
    $rt = $res['results'][0];
    $geo = $rt['geometry'];
    $loc = $geo['location'];
    $result = array(
        'name' => $rt['formatted_address'],
        'types' => $rt['types'],
        'loc_type' => $geo['location_type'],
        'lat' => $loc['lat'],
        'lon' => $loc['lng']
    );
    return $result;
}
