api_test
========

Copied from My **"Yahoo Open Hack Day"** project. (2012 in Taiwan)

1. [ABBYY OCR SDK](http://ocrsdk.com/)
	* file: abbyy_ocr.php
	* usage: abbyy_ocr($imgPath, $lang)
	* example: abbyy_ocr("@/tmp/x.png", 'English')
	* see [Recognition Languages](http://ocrsdk.com/documentation/specifications/recognition-languages/) for **$lang** 	parameter
	* Good support for Chinese
	
2. [Online OCR API Service](http://ocrapiservice.com/)
	* file: ocr_api.php
	* usage: ocr_api($imgPath, $lang)
	
3. [Google Geocoding API](http://developers.google.com/maps/documentation/geocoding)
	* file: google_geocoding.php
	* usage: google_geocoding($addr, $lang)
	
4. [Yahoo Boss Geo - Place Spotter](http://developer.yahoo.com/boss/geo/docs/index.html)
	* file: yboss_place_spotter.php
	* usage: boss_place_spotter($content, $lang = 'en-US', $isHtml = false, $confidence = 8)
	* see [Web Service Spec](http://developer.yahoo.com/boss/geo/docs/placespotter_webservice.html)
	* it requires oauth.inc
	
5. [YQL](http://developer.yahoo.com/yql/)
	* file: yql.php
	* usage: yql($query)
