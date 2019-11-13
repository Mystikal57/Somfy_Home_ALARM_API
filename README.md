# Somfy_Home_ALARM_API
Utilisation des api myfox pour somfy home alarm



1) S'enregistrer le site Somfy https://accounts.somfy.com/register
2) Creer une application pipo: https://developer.somfy.com/user/29456/apps/add
3) Récupérer le token via les infos sur cette page: https://developer.somfy.com/apis-docs
Request authorization
A fresh token must be generated to be able to perform API calls. The token can be requested by redirecting the resource owner user agent to the following authentication server endpoint:

https://accounts.somfy.com/oauth/oauth/v2/auth?response_type=code&client_id=YOUR_CONSUMER_KEY&redirect_uri=https%3A%2F%2Fyour-domain.com%2Fsomewhere&state=YOUR_UNIQUE_VALUE&grant_type=authorization_code
A successful authorization will pass the client the authorization code in the URL via the supplied redirect_uri:

https://your-domain.com/somewhere?code=CODE_GENERATED_BY_SOMFY&state=YOUR_UNIQUE_VALUE
Once this is done, a token can be requested using the authorization code (this code has a short life validity time):

https://accounts.somfy.com/oauth/oauth/v2/token?client_id=YOUR_CONSUMER_KEY&client_secret=YOUR_CONSUMER_SECRET&grant_type=authorization_code&code=CODE_GENERATED_BY_SOMFY&redirect_uri=https%3A%2F%2Fyour-domain.com%2Fsomewhere&state=YOUR_UNIQUE_VALUE
If all went well, you will get a response like this:

{ 
"access_token": "*************************************************************", 
"expires_in": 3600, 
"token_type": "bearer", 
"scope": "**** **** ****", 
"refresh_token": "************************************************************" 
}
Refreshing an expired access_token
To get a new access token, the refresh token is needed. The refresh_token will be valid 14 days.

https://accounts.somfy.com/oauth/oauth/v2/token?client_id=YOUR_CONSUMER_KEY&client_secret=YOUR_CONSUMER_SECRET&grant_type=refresh_token&refresh_token=REFRESH_TOKEN

4) Se servir des infos ici pour obtenir les différents ID de site & device: https://developer.somfy.com/somfy-open-api/apis
5) Modifier la page parametres.php avec vos données
6) appeler la page control.php avec l'argument action= armed, disarmed, partial, notif_off ou notif_on
ex: control.php?action=armed
