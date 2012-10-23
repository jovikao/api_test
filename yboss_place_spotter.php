<?php
require_once 'oauth.inc';
define('BOSS_PS_URL', 'http://yboss.yahooapis.com/geo/placespotter');
define('BOSS_KEY', 'YOUR YAHOO BOSS KEY');
define('BOSS_SEC', 'YOUR YAHOO BOSS SEC');

function boss_place_spotter($content, $lang = 'en-US', $isHtml = false, $confidence = 8){
//    $txtApcKeySuffix = microtime(true);
//    $txtApcKey = "txt_$txtApcKeySuffix";
//    error_log("save text to apc:$txtApcKey");
//    setCache($txtApcKey, $content, 1440); //cache 2 minutes
    $url = BOSS_PS_URL;
    $consumer = new OAuthConsumer(BOSS_KEY, BOSS_SEC);
    $params = array(
        'outputType' => 'json',
//        'documentURL' => "http://ohd.eventloops.in/text.php?key=$txtApcKeySuffix",
        'documentContent' => urlencode($content),
        'confidence' => $confidence,
        'documentType' => urlencode($isHtml? 'text/html': 'text/plain'),
        'inputLanguage' => $lang
    );
    $request = OAuthRequest::from_consumer_and_token($consumer, NULL,'POST', $url, $params);
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);

    $headers = array($request->to_header());
    $url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($params));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode != 200){
        $errNo = curl_errno($ch);
        $err = curl_error($ch);
        error_log("Request to Yahoo! Boss Place Spotter API Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$resp");
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    $resp = json_decode($resp, true);
    return $resp;
}
