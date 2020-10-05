<?php
require_once('auth.php');
require('parametres.php');
$url_state = "https://api.myfox.io/v3/site/".$site_id."?access_token=".$access_token;


$state = json_decode(file_get_contents($url_state));
echo $state->security_level;
?>
