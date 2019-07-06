<?php
//
//  IBM Watson API Speech to Text
//
define("WTS_BASE_URL",    "https://stream.watsonplatform.net");
define("WTS_SERVICE",     "/speech-to-text");
define("WTS_VERSION",     "/api/v1/recognize");
define("WTS_NARROW_BAND", "zh-CN_NarrowbandModel");
define("WTS_BROAD_BAND",  "zh-CN_BroadbandModel");
define("WTS_REQUEST_URL", WTS_BASE_URL.WTS_SERVICE.WTS_VERSION."?model=");
function Speech_to_Text($audioFile, $audioType, $bandModel) {
    $user = "apikey";
    $APIkey = "{apikey is placed here}";
    $size = filesize($audioFile);
    $data = file_get_contents($audioFile);
    $ch = curl_init();
    switch ($bandModel) {
        case 'Narrow':
            curl_setopt($ch, CURLOPT_URL, WTS_REQUEST_URL.WTS_NARROW_BAND);
            break;
        case 'Broad':
            curl_setopt($ch, CURLOPT_URL, WTS_REQUEST_URL.WTS_BROAD_BAND);
            break;
        default:
            curl_setopt($ch, CURLOPT_URL, WTS_REQUEST_URL.WTS_BROAD_BAND);
            break;
    }
    curl_setopt($ch, CURLOPT_USERPWD, "apikey:".$APIkey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: $audioType",
        "Transfer-Encoding: chunked"
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_INFILESIZE, $size);
    curl_setopt($ch, CURLOPT_POST, 1);
    $json = @curl_exec($ch);
    return $json;
}
?>