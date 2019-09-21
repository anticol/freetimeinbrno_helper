<?php

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$jsonurl = 'https://gis.brno.cz/ost/pasport-sportovist-new/service/getResults.php';

$json = file_get_contents($jsonurl, false, stream_context_create($arrContextOptions));
$json_obj = json_decode($json, true);

foreach($json_obj['venues'] as &$value) {
    $value['address'] = preg_replace('/[,]+/', ' -', trim($value['address']));
    $value['address'] = preg_replace('/[\n]+/', ' ', trim($value['address']));
    $value['address'] = preg_replace('/[\r]+/', ' ', trim($value['address']));
}

//echo '<pre>'; print_r($json_obj['venues']); echo '</pre>';

$out = "id,name,address,lng,lat,img\r\n";
foreach($json_obj['venues'] as $arr) {
    $out .= implode(",", $arr) . "\r\n";
}

echo $out
 
?>