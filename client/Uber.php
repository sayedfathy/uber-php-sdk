<?php

/**
 * Uber
 * A PHP-based Uber client library
 * 
 * @package uber_api 
 * @author  Sayed Fathy
 * @version 0.1
 * @license GPLv3 <http://www.gnu.org/licenses/gpl.txt>
 */

/**
 * UberApiException
 * Handels any possible Exception may be occured while using the API
 */
class UberApiException extends Exception {}

/**
 * Uber
 * Provides a wrapper for authenticating and making requests to the
 * Uber API
 */
class Uber {

	private $base_url = "https://api.uber.com/v1/";
	private $authorize_url = "https://login.uber.com/oauth/v2/authorize";
	private $token_url = "https://login.uber.com/oauth/v2/token";

	private $client_id;
	private $client_secret;
	private $response_type='code';
	private $grant_type='authorization_code';
	private $redirect_uri;
	private $access_token;
	private $scope;
	private static $curl;
	
	/**
	* Returns the *Uber* instance of this class.
	*
	* @return Uber The *Uber* instance.
	*/

	public function __construct(){
		$this->curl = new UberCurl();
		$this->access_token = new AccessToken();
	}

	public function setClientId($client_id) {
		$this->client_id = $client_id;
	}

	public function getClientId() {
		if (isset($this->client_id)) {
			return $this->client_id;
		}
		
		throw new UberApiException("There is no client id, call setClientId() first");
	}

	public function setScope($scope) {
		$this->scope = $scope;
	}

	public function getScope() {
		if (isset($this->scope)) {
			return $this->scope;
		}
		
		throw new UberApiException("There is no scopes, call setScope() first");
	}

	public function setAccessToken($access_token) {
		$this->access_token = $access_token;
	}

	public function getAccessToken() {
		if (isset($this->access_token)) {
			return $this->access_token;
		}
		if (isset($this->code)) {
			throw new UberApiException("There is no acess token, call authenticate() first");
		} else {
			throw new UberApiException("There is no acess token, call get_authorization_url() and then authenticate() first");
		}
	}

	public function setClientSecret($client_secret) {
		$this->client_secret = $client_secret;
	}

	public function getClientSecret() {
		if (isset($this->client_secret)) {
			return $this->client_secret;
		}

		throw new UberApiException("There is no client secret, call setClientSecret() first");
	}

	public function setRedirectUri($redirect_uri) {
		$this->redirect_uri = $redirect_uri;
	}

	public function getRedirectUri() {
		if (isset($this->redirect_uri)) {
			return $this->redirect_uri;
		}

		throw new UberApiException("There is no redirect uri, call setRedirectUri() first");
	}


	public function get_authorization_url() {
		$login_url = $this->authorize_url."?response_type=".$this->response_type."&client_id=".$this->getClientId()."&redirect_uri=".$this->getRedirectUri();
		try {
			$login_url .="&scope=".$this->getScope();
		} catch(UberApiException $e) {}
		return $login_url;
	}

	public function authenticate($code) {
		$this->code = $code;		
		$fields = array(
				'client_id'=>urlencode($this->getClientId()),
				'client_secret'=>urlencode($this->getClientSecret()),
				'redirect_uri'=>urlencode($this->getRedirectUri()),
				'grant_type'=>urlencode($this->grant_type),
				'code'=>urlencode($code),
			);		

		$token_data = $this->curl->execute($this->token_url,$method='post',$fields=$fields);
		$access_token = new AccessToken();	
		$access_token->setValue($token_data->access_token);
		$access_token->setRefreshToken($token_data->refresh_token);
		$access_token->setExpireIn($token_data->expires_in);
		$access_token->setTokenType($token_data->token_type);
		$access_token->setScope($token_data->scope);
		$this->access_token = $access_token;
		return $this->access_token;
	}

	public function request($end_point,$access_token=Null,$params = Null ) {
		$request_url = $this->base_url.$end_point;
		if(!isset($access_token)) {
			$access_token = $this->access_token->getValue();
		}

		if(isset($params)) {
			$fields_string='';
			foreach($params as $key=>$value) {
				$fields_string .= $key.'='.$value.'&'; 
			}
			$request_url .="?".rtrim($fields_string, '&');
		}

		$data = $this->curl->request($request_url,$access_token);
		return $data;
	}

	
}