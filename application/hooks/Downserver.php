<?php
defined('BASEPATH') or exit('No direct scripts allowed to access');
class Downserver extends CI_Controller {
	protected $CI;

	public function __construct() {
		$this->CI = & get_instance();
	} 
	public function check_suspend_status() {
		exit('<div style="text-align:center;color:red;margin-top:5%;"><h1>503 ERRROR</h1><span>Service Unavailable</span><p style="font-size:17px;">Contact To Administrator For Any Queries</p></diiv>');
	}
}