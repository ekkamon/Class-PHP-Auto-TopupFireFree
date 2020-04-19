<?php

class FreeFire
{
	public $open_id = null;

	public function getHeaders($array){
		$headers = array();
		foreach ($array as $key => $value) {
			$headers[] = $key.": ".$value;
		}
		return $headers;
	}

	public function request($method, $url, $data = null, $headers = array()){
		$ch = curl_init();
		if(!is_null($data)){
			curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
			if (is_array($data)) $headers = array_merge(array(
				"Accept" => "application/json",
				"Content-Type" => "application/json",
			), $headers);	
		}
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_PROXY => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.92 Safari/537.36",
			CURLOPT_HTTPHEADER => $this->getHeaders($headers),
		));
		$this->response = curl_exec($ch);
		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($result = json_decode($this->response, true)) {
			if (isset($result["data"])) $this->data = $result["data"];
			return $result;
		}
		return $this->response;
	}

	public function Login($game_id = null){
		if (is_null($game_id)) return false;
		$result = $this->request("POST", "https://termgame.com/api/auth/player_id_login", array(
			"app_id" => 100067,
			"login_id" => strval($game_id)
		));
		$this->open_id = $result["open_id"];
		return $result;
	}

	public function BuyDiamond($card = null){
		if(is_null($this->open_id) || is_null($card)) return false;
		$result = $this->request("POST", "https://termgame.com/api/shop/pay/init?language=th&region=IN.TH", array(
			"app_id" => 100067,
			"channel_data" => array(
				"card_password" => strval($card),
				"friend_username" => null
			),
			"channel_id" => 207000,
			"open_id" => strval($this->open_id),
			"packed_role_id" => 0,
			"service" => "pc"
		));

		return $result;
	}
}