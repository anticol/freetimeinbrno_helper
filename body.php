<?php

   $json = '
   {
      "dataBrnoLapka": [
         {
            "dataBrnoLapka":
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
   $result = print_r(json_encode($newData['dataBrnoLapka'][0]['dataBrnoLapka']),true);
  $readyToParse = json_decode($result,true);
  #print_r($readyToParse);

  $out = "id,idOkruhu,nazevOkruhu,kratkyPopisOkruhu,dlhyPopisOkruhu,nejakeBase64,vzdialenost,dlzka,bicykel,deti,longOkruhu,latOkruhu,Array,cislo5,ID2,nazevZastavky,descriptionBase64,photoUrl,gpsLng,gpsLat\r\n";
$myID = 0;
foreach($readyToParse as $arr) 
{

  foreach ($arr as $key => &$value) {
  if ($key != "spots") {
	
    $value = preg_replace('/[,]+/', ' -', trim($value));
    $value = preg_replace('/[\n]+/', ' ', trim($value));
    $value = preg_replace('/[\r]+/', ' ', trim($value));
  }
  }

foreach ($arr as $key => &$value) {
  if ($key == "spots"){
  		foreach ($value as $spots_key) {
			$spots_key = $array = array_values($spots_key);
			$spots_key[2] = preg_replace('/[,]+/', ' -', trim($spots_key[2]));
			#echo $spots_key[2];
  			$new = implode(",", $spots_key);
			#echo $new;
  			$out .= $myID . "," . implode(",", $arr) . "," . $new . "\r\n";
  			$myID = $myID + 1;
  		}
  	}
  }
  #print_r($arr);
  
}

echo $out;
   #print_r($newData);
   #var_export($newData);

