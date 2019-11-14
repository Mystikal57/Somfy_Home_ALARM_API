<?php
session_start();
require_once('parametres.php');
if ($log_level == 1) $log = date("F j, Y, g:i a").PHP_EOL;

function new_token($client_id,$client_secret,$password,$username)
{
        global $log,$log_level;
        $url = "https://sso.myfox.io/oauth/oauth/v2/token";
        $data_json = '{"client_id":"'.$client_id.'","client_secret":"'.$client_secret.'","grant_type":"password","password":"'.$password.'","username":"'.$username.'"}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        $_SESSION["access_token"] = substr(preg_split("/:|,/",substr($response, 1, -1))[1],1,-1);
        $_SESSION["refresh_token"] = substr(preg_split("/:|,/",substr($response, 1, -1))[9],1,-1);
        curl_close($ch);
        if ($log_level == 1) $log .= "new token ok".PHP_EOL;
        return $log;
}

function refresh_token($client_id,$client_secret,$refresh_token)
{
        global $log_level,$log;
        $url = "https://sso.myfox.io/oauth/oauth/v2/token";
        $data_json = '{"client_id":"'.$client_id.'","client_secret":"'.$client_secret.'","grant_type":"refresh_token","refresh_token":"'.$refresh_token.'"}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        if(strpos($response,"invalid") != false){
                return "erreur";
        }
        else{
                $_SESSION["access_token"]= substr(preg_split("/:|,/",substr($response, 1, -1))[1],1,-1);
                $_SESSION["refresh_token"] = substr(preg_split("/:|,/",substr($response, 1, -1))[9],1,-1);
                if ($log_level == 1) $log .= "refresh ok".PHP_EOL;
                return $log;
        }
}

$url = "https://api.myfox.io/v3/site/".$site_id."?access_token=".$access_token;
$data_json = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        if ((strpos($response,"unauthorized") != false) || $_SESSION["site_id"] != "1"){
                $response = refresh_token($client_id,$client_secret,$refresh_token);
                if ($response == "erreur") $response = new_token($client_id,$client_secret,$password,$username);
        }
//Save string to log, use FILE_APPEND to append.
if ($log_level == 1) $log .= "-------------------------".PHP_EOL;
if ($log_level == 1) file_put_contents('./token.log', $log, FILE_APPEND);


?>
