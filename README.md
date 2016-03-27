### PHP Uber SDK

* * *
# Usage

1.  Download and Installing
2.  Authentication

**Download and Installing**

Clone the code inside your server directory. require the autoload file `require 'client/autoload.php'`

instantiate an object from Uber class and then set your app configurations.

`$uber = new Uber();`

`$client_id = 'YOUR_CLIENT_ID';`

`$client_secret = 'YOUR_CLIENT_SECRET';`

`$redirect_uri = 'YOUR_REDIRECT_URI';`

`$scope = 'YOUR_PREFERED_SCOPE';`

`$uber->setClientId($client_id);`

`$uber->setClientSecret($client_secret);`

`$uber->setRedirectUri($redirect_uri);`

`$uber->setScope('profile histroy');`

* * *

**Authentication**
## STEP ONE: AUTHORIZE

Call get_authorization_url() function to get the login URL

`$login_url = $uber->get_authorization_url();`

`echo "[Login with Uber]($login_url)";`

Once the Uber user authenticates and authorizes your app, Uber will issue an HTTP 302 redirect to the redirect_uri passed in. On that redirect, you will receive an authorization code, which is single use and expires in 10 minutes.

## STEP TWO: GET AN ACCESS TOKEN

Call authenticate() function and pass the code you get from step one as a parameter, this function retruns an object from access token you should save it.

`$token = $uber->authenticate($_GET['code']);`

`$_SESSION['token'] = $token->getValue();`

## STEP Three: USE Access TOKEN

Call request function which will allow you to make requests on behalf of a user

`$token = $_SESSION['token'];`

`$result = $uber->request('me',$token);`

`// $result = $uber->request('products',$token,["latitude"=>"37.7759792","longitude"=>'-122.41823']);`

request function takes 3 parameters

1.  Endpoint `string`, you can know more about it from uber api itself.
2.  access token `string`, that we got from step two.
3.  params (optional) `array`, determines the parameters you are gonna send with your request
