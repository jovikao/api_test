* DIR **ci/** Codeigniter upload application - include a controller & a view to handle file upload
* DIR **upload/** upload UI - include html/css/js files to render upload UI 
* Change url path in **upload/assets/js/script.js** to meet your CI env.
* Default image store target is **/tmp**
* To fix return same upload result problem, we add a new random parameter to upload POST (see https://github.com/jovikao/api_test/blob/master/ci_upload/upload/assets/js/jquery.filedrop.js#L211 )