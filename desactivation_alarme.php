<?php

#url pour activation / desactivation
$url = "https://api.myfox.io/v3/site/VOTRE_SITE/security?access_token=VOTRE_TOKEN";
$ch = curl_init();
$data_json = '{"status":"disarmed"}';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);

echo $response;
?>
