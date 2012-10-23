<?php
define('YQL_BASE_URL', 'https://query.yahooapis.com/v1/public/yql');

function yql($query){
    $qURL = sprintf('%s?q=%s&format=json', YQL_BASE_URL, urlencode($query));
    $ch = curl_init($qURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode != 200){
        $errNo = curl_errno($ch);
        $err = curl_error($ch);
        error_log("Request to YQL Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$res");
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    $res = json_decode($res, true);
    if(!isset($res['query']['results'])){
        error_log("Request to YQL Fail - No result - ".json_encode($res));
        return false;
    }
    $results = $res['query']['results'];
    return $results;
}
