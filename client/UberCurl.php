<?php

class UberCurl {	
/**
 * Handler Class provides a mechanism to use curl function 
 * to fetch the response
 */

	public function request($url,$access_token,$params=false) {
		$headers = array();
		$headers[] ='Authorization: Bearer '.$access_token;
		$headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		$data = curl_exec($ch);
		
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = ($httpcode>=200 && $httpcode<300) ? $data : false;

		return json_decode($data);	

	}

	public function execute($url,$method='get',$fields=Null){
		
		if($method=='get') {
			return $this->curl_get($url);
		} else if($method=='post') {
			return $this->curl_post($url,$fields);
		} 
		
	}

	public function curl_post($url,$fields) {
		$fields_string='';
		foreach($fields as $key=>$value) {
			$fields_string .= $key.'='.$value.'&'; 
		}
		rtrim($fields_string, '&');

		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//close connection
		curl_close($ch);
		$data = ($httpcode>=200 && $httpcode<300) ? $data : false;

		return json_decode($data);

	}

	public function curl_get($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = ($httpcode>=200 && $httpcode<300) ? $data : false;

		return json_decode($data);
	}

}
