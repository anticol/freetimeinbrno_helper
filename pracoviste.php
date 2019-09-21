<?php

   $json = '
   {
      "dataBrnoPracoviste": [
         {
            "dataBrnoPracoviste":
            [
               []
            ]
         }
      ]
   }';

   $data = array(
      '_JSONData_' => $json, // predavam jako string
   );

   /* zabezpecena komunikace */
   $tuCurl = curl_init();
   curl_setopt($tuCurl, CURLOPT_URL, "https://is.luzanky.cz/api.php");
   curl_setopt($tuCurl, CURLOPT_POST, TRUE);
   curl_setopt($tuCurl, CURLOPT_ENCODING, "UTF-8" );
   curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data);
   curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, TRUE); // Docasne vypnute overeni CA
   curl_setopt($tuCurl, CURLOPT_SSL_VERIFYHOST, 2);
  

   $tuData = curl_exec($tuCurl);
   #echo $tuData;
   $newData = json_decode($tuData, true);
   $result = print_r(json_encode($newData['dataBrnoPracoviste'][0]['dataBrnoPracoviste']),true);

  $readyToParse = json_decode($result,true);

  $out = "id,nazev,adresa,gpsLng,gpsLat,telefon,email,webURL,anotace,popis,fotoURL\r\n";
foreach($readyToParse as $arr) {
  foreach ($arr as &$key) {
    $key = preg_replace('/[,]+/', ' -', trim($key));
    $key = preg_replace('/[\n]+/', ' ', trim($key));
    $key = preg_replace('/[\r]+/', ' ', trim($key));
    #print_r($key);
  }
  #print_r($arr);
  $out .= implode(",", $arr) . "\r\n";
}

echo $out;
   #print_r($newData);
   #var_export($newData);

