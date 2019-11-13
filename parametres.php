<?php

$access_token = "VOTRE_ACCESS_TOKEN";
$site_id = "VOTRE_SITE_ID";
$device_id = "VOTRE_DEVICE_ID";
$label_siren = "NOM_DE_VOTRE_SIRENE_INTERIEURE";
$infos_user = "https://api.myfox.io/v3/user?access_token=".$access_token;
$details_user = json_decode(file_get_contents($infos_user));
$delais_activation = ($details_user->sites[0]->exit_delay)+5; #delais d'activation de votre alarme +5 secs

?>
