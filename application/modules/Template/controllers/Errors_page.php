<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
ini_set('display_errors', 0);
class Errors_page extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data["page_title"] = '404 Error Page';
        $data["content_view"] = 'Template/error_404_tempate';
        $this->output->set_status_header('404');
        $this->template->base_template($data);
    }

    public function access_denied() {
        $data["page_title"] = '403 Access Denied';
        $data["content_view"] = 'Template/permission_error_403';
        $this->output->set_status_header('404');
        $this->template->base_template($data);
    }
}