<?php

/**
* ===================================================
* Encryption/Decryption Class
* @author Sherwin Macalintal
* @version 1.2.0
* ===================================================
*/

class Crypt {

	/* Secret Key for encryption class */
	private $_key = 'U$ySodoPK5IHQ0Y4286p_3G5t4FTOMQGtzU2o_dNPA4FTCkKYk%4spUhfttA#UJ5';

	/* Secret IV for encryption class */
	private $_iv = 'mCx7eLBp!Sxrefkzv8pxJYaM6Y7QiBTd';


	/**
	* Encrypt data
	* @param mixed(array or string) $data
	* @return mixed encrypted data
	*/
	public function encode($data) {
		$action = 'encode';
		$keycode = $this->key_encoder($this->_key);
		$iv = $this->iv_encoder($this->_iv);
		$cper = $this->cipher_method();

		if(is_array($data)) {
			$output = array();
			foreach($data as $k => $val) {
				$output[$k] = $this->text_coder($val, $cper, $keycode, $iv, $action);
			}
			return $output;
		} else {
			return $this->text_coder($data, $cper, $keycode, $iv, $action);
		}
	}


	/**
	* Decrypt data
	* @param mixed(array or string) $data
	* @return mixed decrypted data
	*/
	public function decode($data) {
		$action = 'decode';
		$keycode = $this->key_encoder($this->_key);
		$iv = $this->iv_encoder($this->_iv);
		$cper = $this->cipher_method();

		if(is_array($data)) {
			$output = array();
			foreach($data as $k => $val) {
				$output[$k] = $this->text_coder($val, $cper, $keycode, $iv, $action);
			}
			return $output;
		} else {
			return $this->text_coder($data, $cper, $keycode, $iv, $action);
		}
	}


	/**
	* Encrypt/Decrypt pass string
	* @param string $val
	* @param Cipher Method $cper
	* @param string $key hash key
	* @param string $iv 16 byte hash key
	* @param string $action
	* @return encrypted data
	*/
	private function text_coder($val, $cper, $key, $iv, $action) {
		if($action == 'encode') {
			return base64_encode(openssl_encrypt($val, $cper, $key, 0, $iv));
		} elseif($action == 'decode') {
			return openssl_decrypt(base64_decode($val), $cper, $key, 0 , $iv);
		} else {
			return false;
		}
	}


	/**
	* Hash key for encryption/decryption
	* @param string $key
	* @return hash key
	*/
	private function key_encoder($key) {
		return hash('sha256', $key);
	}


	/**
	* Encrypt method AES-256-CBC expects 16 bytes
	* @param string $iv
	* @return 16 byte hash key
	*/
	private function iv_encoder($key) {
		return substr(hash('sha256', $key), 0, 16);
	}


	/**
	* Cipher Method for Open SSL
	*/
	private function cipher_method() {
		return trim("AES-256-CBC");
	}

	/**
	 * generate random characters
	 * @param int $count 	number of characters to be returned
	 * @return random
	 */
	public function randChars($length = 16) {
		$rand = '';
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcedfghijklmnopqrstuvwxyz';

		for($x = 0; $x < $length; $x++) {
			$rand .= $characters[mt_rand(0, strlen($characters) - 1)];
		}

		return $rand;
	}

	/**
	 * generate random number
	 * @param int $count 	number of characters to be returned
	 * @return random
	 */
	public function randNumbers($length = 4) {
		$rand = '';
		$characters = '123456789';

		for($x = 0; $x < $length; $x++) {
			$rand .= $characters[mt_rand(0, strlen($characters) - 1)];
		}

		return $rand;
	}

	/**
	* get ip address of client
	* @return string
	*/
	public static function getIpAddress() {
		// check for shared internet/ISP IP
		if(!empty($_SERVER['HTTP_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		// check for IPs passing through proxies
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// check if multiple IPs exist in var
			if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== FALSE) {
				$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach($iplist as $ip) {
					if($this->validateIp($ip)) return $ip;
				}
			} else {
				if(self::validateIp($_SERVER['HTTP_X_FORWARDED_FOR']))
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}

		if(!empty($_SERVER['HTTP_X_FORWARDED']) && self::validateIp($_SERVER['HTTP_X_FORWARDED'])) return $_SERVER['HTTP_X_FORWARDED'];

		if(!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];

		if(!empty($_SERVER['HTTP_FORWARDED_FOR']) && self::validateIp($_SERVER['HTTP_FORWARDED_FOR'])) return $_SERVER['HTTP_FORWARDED_FOR'];

		if(!empty($_SERVER['HTTP_FORWARDED']) && self::validateIp($_SERVER['HTTP_FORWARDED'])) return $_SERVER['HTTP_FORWARDED'];

		// return unreliable IP since all else failed
		return $_SERVER['REMOTE_ADDR'];
	}

}