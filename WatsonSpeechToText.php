<?php
//
//  IBM Watson API Speech to Text
//
define("WTS_BASE_URL",    "https://stream.watsonplatform.net");
define("WTS_SERVICE",     "/speech-to-text");
define("WTS_VERSION",     "/api/v1/recognize");
define("WTS_NARROW_BAND", "ja-JP_NarrowbandModel");
define("WTS_BROAD_BAND",  "ja-JP_BroadbandModel");
define("WTS_REQUEST_URL", "https://stream.watsonplatform.net/speech-to-text/api/v1/recognize?model=zh-CN_BroadbandModel");
function Speech_to_Text($audioFile, $audioType) {
    $user = "apikey";
    $size = filesize($audioFile);
    $data = file_get_contents($audioFile);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, WTS_REQUEST_URL);
    curl_setopt($ch, CURLOPT_USERPWD, "apikey:***");
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