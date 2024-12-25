<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class App_menu extends MY_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('userid'))
			return redirect('login');
            $this->load->model('Template/Menu_model','menu_model');
    }

    public function settings_template() {
        $data["page_title"] = 'Settings';
        $data["content_view"] = 'App_menu/settings_templete_v1';
        $data["menu_data"] =$this->menu_model->registered_menus("SETTINGS");
        $this->template->base_template($data);
    }

    public function branch_setting() {
        $data["page_title"] = 'Branch Settings';
        $data["content_view"] = 'App_menu/branch_settings_template_v1';
        $this->template->base_template($data);
    }

    public function reports_template() {
        $data["page_title"] = 'Reports';
        $data["content_view"] = 'App_menu/reports_templete_v1';
        $this->template->base_template($data);
    }

     
}