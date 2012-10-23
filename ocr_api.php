<?php
function ocr_api($imgPath, $lang){
    $apiKey = 'apiKey';
    $post = array(
        'image'=> $imgPath,
        'language' => $lang,
        'apikey' => $apiKey
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, OCR1_URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode != 200){
        $errNo = curl_errno($ch);
        $err = curl_error($ch);
        error_log("Request to OCR API Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$res");
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    return $res;
}
