<?php
ini_set( 'display_errors', 0 );

if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "files/" . $_FILES["file"]["name"])) {
      $file_type = explode(".",$_FILES["file"]['name']);
      $file_type = end($file_type);
      if ($file_type==='mp3'){
        require_once("WatsonSpeechToText.php");
        $mes['filename'][] = '[' . $_FILES["file"]["name"] . "]";
        $transcripts = Speech_to_Text("files/" . $_FILES["file"]["name"], "audio/mp3");
        $arr = json_decode($transcripts, true);
        $i = 0;
        foreach ($arr['results'] as $r) {
            foreach ($r['alternatives'] as $rr) {
                $mes['data'][] = array(
                    "id" => $i,
                    "trans" => $rr['transcript']
                );
                $i = $i + 1;
            }
        }
        $mes['message'][]= "Prosess Completed.";
        header('Content-type: application/json; charset=utf-8');
        $json = json_encode($mes);
        echo $json;
      }else{
        $mes['error'][]= "正しい形式のファイルを選択してください．";
        header('Content-type: application/json; charset=utf-8');
        $json = json_encode($mes);
        echo $json;
      }   
    } else {
      $mes['error'][]= "ファイルをアップロードできません。";
      header('Content-type: application/json; charset=utf-8');
        $json = json_encode($mes);
        echo $json;
        
    }
  } else {
    $mes['error'][]= "ファイルが選択されていません。";
    header('Content-type: application/json; charset=utf-8');
    $json = json_encode($mes);
    echo $json;
}
?>