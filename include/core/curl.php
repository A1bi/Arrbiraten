<?php
/**
 * 7stroem
 *
 * curl class
 * handles connections to remote hosts
 */
class curl {

	private $curl;
	private $headers = array(
		"Accept-Language: de-de,de;q=0.8"
	);
	private $url;

	/**
	 * creates curl object with given url
	 * in case $proxy is set it will enable the proxy
	 *
	 * @global class $_settings
	 * @param string $url
	 * @param int $proxy
	 */
	function __construct($url = "", $proxy = 1) {
		$this->url = $url;
		$this->curl = curl_init($url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);

	}

	private function getQueryString($a) {
		foreach ($a as $name => $value) {
			$args .= $name . "=" . $value . "&";
		}
		return $args;
	}

	/**
	 * parses post arguments
	 *
	 * @param array $posts
	 */
	function post($posts) {
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->getQueryString($posts));
	}

	function setGetArgs($gets) {
		curl_setopt($this->curl, CURLOPT_URL, $this->url . "?" . $this->getQueryString($gets));
	}

	/**
	 * sets cookies which are later sent to the host
	 *
	 * @param array $cookies
	 */
	function setCookies($cookies) {
		foreach ($cookies as $name => $value) {
			$args .= $name . "=" . $value . ";";
		}
		curl_setopt($this->curl, CURLOPT_COOKIE, $args);
	}

	/**
	 * filters a cookies which the server wants us to set
	 *
	 * @param string $name
	 */
	function getCookie($name) {
		// set opt to get the header which contains the cookies
		curl_setopt($this->curl, CURLOPT_HEADER, true);
		// filter cookie
		preg_match("#".$name."=(.*);#isU", $this->response(), $cookie);
		// set back to false
		curl_setopt($this->curl, CURLOPT_HEADER, false);

		return $cookie[1];
	}
	
	function downloadToFile($name) {
		curl_setopt($this->curl, CURLOPT_FILE, $name);
		$this->execute();
	}

	/**
	 * return response of the remote host
	 *
	 * @return curl
	 */
	function response() {
		$response = $this->execute();
		if (curl_errno($this->curl)) {
			return false;
		} else {
			return $response;
		}
	}
	
	protected function execute() {
		return curl_exec($this->curl);
	}

	/**
	 * closes connection
	 */
	function close() {
		curl_close($this->curl);
	}
	
}
?>