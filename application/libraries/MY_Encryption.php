<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Encryption {
    protected $_key;
	protected $cipher = 'AES-256-CBC';
	protected $secret_key;
    protected $secret_iv;
    protected $key;
    protected $iv;

    public function __construct() {
    	if ( ! isset($this->_key) && strlen($secret_key = config_item('secret_key')) > 0)
		{
			$this->secret_key = $secret_key;
		}

		if ( ! isset($this->_key) && strlen($secret_iv = config_item('secret_iv')) > 0)
		{
			$this->secret_iv = $secret_iv;
		}
		$this->key = hash('sha256', $this->secret_key);
        $this->iv = substr(hash('sha256', $this->secret_iv),0,16);
    }

    public function encrypt($val) {
        return base64_encode(openssl_encrypt( $val, $this->cipher, $this->key, 0, $this->iv ) );
    }

    public function decrypt($val) {
        return openssl_decrypt(base64_decode($val), $this->cipher, $this->key, 0, $this->iv );
    }
}