### PHP Uber SDK

* * *

**Usage**

1.  Download and Installing
2.  Authentication

**Download and Installing**

Clone the code inside your server directory. require the autoload file `require 'client/autoload.php'`

instantiate an object from Uber class and then set your app configurations.

`$client_id = 'YOUR_CLIENT_ID';  
$client_secret = 'YOUR_CLIENT_SECRET';  
$redirect_uri = 'YOUR_REDIRECT_URI';  
$scope = 'YOUR_PREFERED_SCOPE';  
$uber = new Uber();  
$uber->setClientId($client_id);  
$uber->setClientSecret($client_secret);  
$uber->setRedirectUri($redirect_uri);  
$uber->setScope('profile histroy');  
`
