<?php
require_once('auth.php');
require('parametres.php');
$action = $_GET["action"];

$site_id = $_SESSION['site_id'];
$device_id = $_SESSION['device_id'];
$label_siren = $_SESSION['label_siren'];

switch ($action){
        case "armed":
                $url = "https://api.myfox.io/v3/site/".$site_id."/security?access_token=".$access_token;
                $data_json = '{"status":"armed"}';
                break;
        case "disarmed":
                $url = "https://api.myfox.io/v3/site/".$site_id."/security?access_token=".$access_token;
                $data_json = '{"status":"disarmed"}';
                break;
        case "partial":
                $url = "https://api.myfox.io/v3/site/".$site_id."/security?access_token=".$access_token;
                $url_sirene = "https://api.myfox.io/v3/site/".$site_id."/device/".$device_id."?access_token=".$access_token;
                $data_json = '{"settings":{"global":{"sound_enabled":false,"auto_protect_enabled":true,"light_enabled":true}},"label":"'.$label_siren.'"}';
                $data_json2 = '{"status":"partial"}';
                $data_json3 = '{"settings":{"global":{"sound_enabled":true,"auto_protect_enabled":true,"light_enabled":true}},"label":"'.$label_siren.'"}';
                break;
        case "notif_off":
                $url = "https://api.myfox.io/v3/site/".$site_id."/device/".$device_id."?access_token=".$access_token;
                $data_json = '{"settings":{"global":{"sound_enabled":false,"auto_protect_enabled":true,"light_enabled":true}},"label":"'.$label_siren.'"}';
                break;
        case "notif_on":
                $url = "https://api.myfox.io/v3/site/".$site_id."/device/".$device_id."?access_token=".$access_token;
                $data_json = '{"settings":{"global":{"sound_enabled":true,"auto_protect_enabled":true,"light_enabled":true}},"label":"'.$label_siren.'"}';
                break;
        case "weekend":
                $url = "https://api.myfox.io/v3/site/".$site_id."/security?access_token=".$access_token;
                $url_sirene = "https://api.myfox.io/v3/site/".$site_id."/device/".$device_id."?access_token=".$access_token;
                $data_json = '{"settings":{"global":{"sound_enabled":false,"auto_protect_enabled":true,"light_enabled":true}},"label":"'.$label_siren.'"}';
                $data_json2 = '{"status":"partial"}';
                $data_json3 = '';
                $action = "partial";
                break;
}
if($action != "partial"){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
}
else{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_sirene);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        sleep($delais_activation);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_sirene);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
}
?>
