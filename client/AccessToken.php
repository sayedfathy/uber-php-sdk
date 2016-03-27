<?php
class AccessToken {
	public $value;
	public $token_type;
	public $refresh_token;
	public $expire_in;
	public $scope;

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}
	
	public function setTokenType($token_type) {
		$this->token_type = $token_type;
	}

	public function getTokenType() {
		return $this->token_type;
	}

	public function setExpireIn($expire_in) {
		$this->expire_in = $expire_in;
	}

	public function getExpireIn() {
		return $this->expire_in;
	}

	public function setRefreshToken($refresh_token) {
		$this->refresh_token = $refresh_token;
	}

	public function getRefreshToken() {
		return $this->refresh_token;
	}

	public function setScope($scope) {
		$this->scope = $scope;
	}

	public function getScope() {
		return $this->scope;
	}

}
