<?php
function abbyy_ocr($imgPath, $lang){
    $applicationId = 'applicationId';
    $password = 'password';
    $lang = urlencode($lang);//English
    $url = "http://cloud.ocrsdk.com/processImage?language=$lang&exportFormat=txt&profile=textExtraction";
    // Send HTTP POST request and ret xml response
    $ch = curl_init();
    $post_array = array(
        'my_file'=>$imgPath,
    );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$applicationId:$password");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode != 200){
        $errNo = curl_errno($ch);
        $err = curl_error($ch);
        error_log("Request to ABBYY OCR :processImage Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$res");
        curl_close($ch);
        return false;
    }
    curl_close($ch);

    // Parse xml response
    error_log("Request to ABBYY OCR processImage result:$res");
    $xml = simplexml_load_string($res);
    $arr = $xml->task[0]->attributes();

    // Task id
    $taskid = $arr["id"];  
    $url = "http://cloud.ocrsdk.com/getTaskStatus?taskid=$taskid";
    do
    {
        sleep(1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$applicationId:$password");
        $res = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpCode != 200){
            $errNo = curl_errno($ch);
            $err = curl_error($ch);
            error_log("Request to ABBYY OCR :getTaskStatus Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$res");
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        // parse xml
        $xml = simplexml_load_string($res);
        $arr = $xml->task[0]->attributes();
    }
    while($arr["status"] != "Completed");

    // Result is ready. Download it

    $url = $arr["resultUrl"];   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode != 200){
        $errNo = curl_errno($ch);
        $err = curl_error($ch);
        error_log("Request to ABBYY OCR :get result Fail - Code:$httpCode - Error Code:$errNo - Error:$err - Response:$res");
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    if(empty($res)){
        return false;
    }
    return $res;
}
