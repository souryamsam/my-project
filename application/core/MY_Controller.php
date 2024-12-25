<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends MX_Controller {
    public $thatdate;
    public $userid;
    public $session_id;
    public $users;
    public $session_name;
    public function __construct() {
        parent:: __construct();
        $this->thatdate = date('Y-m-d h:i:s');
        $this->userid = $this->my_encryption->decrypt($this->session->userdata('userid'));
        $this->session_id = $this->my_encryption->decrypt($this->session->userdata('session'));
        $this->session_name = $this->session->userdata('SESSION_NAME');
        $this->load->module('Template');
    }
    
    function get_permitted_pages(){
        $pages = [];
        if($this->session->userdata("menus")){
            $menus = $this->session->userdata("menus");
            if(!empty($menus)) {
                foreach($menus as $mrow) {
                    foreach($mrow["MENU_PAGES"] as $prow) {
                        $pages[] = $prow["PAGE_NAME"];
                    }
                }
            }
        }
        return $pages;
    }
}