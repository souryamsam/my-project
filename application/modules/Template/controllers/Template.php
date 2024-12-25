<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Template extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('User/User_model','user_model');
        $this->load->model("Menu_model","menu");
    }

    public function base_template($data) {
        $page_details = $this->menu->get_page_title($this->uri->segment(1));
        if(!empty($page_details)) {
            if(isset($page_details["PAGE_APP_NAME"])) {
                $data["page_header_name"] = isset($page_details["PAGE_APP_NAME"])?$page_details["PAGE_APP_NAME"]:'';
                $data["page_title"] = isset($page_details["PAGE_APP_NAME"])?$page_details["PAGE_APP_NAME"]:'';
                $data["icon"] = isset($page_details["ICON"])?$page_details["ICON"]:'';
                $data["icon_color"] = isset($page_details["ICON_COLOR"])?$page_details["ICON_COLOR"]:'';
            }
            else{
                $page_name = slug_to_page($this->uri->segment(1));
                $data["page_header_name"] = $page_name;
                $data["page_title"] = $page_name;
                $data["icon"] = "fa fa-chevron-right";
                $data["icon_color"] = "#000000";
            }
        }
        else{
            $page_name = slug_to_page($this->uri->segment(1));
            $data["page_header_name"] = $page_name;
            $data["page_title"] = $page_name;
            $data["icon"] = "fa fa-chevron-right";
            $data["icon_color"] = "#000000";
        }
        $this->load->view('Template/inc/admin_lte2_header',$data);
        $this->load->view('Template/inc/admin_lte2_sidebar',$data);
        $this->load->view('Template/admin_lte2_content_wrapper',$data);
        $this->load->view('Template/inc/admin_lte2_footer',$data);
        $this->load->view('Template/modals/day_care_modal_template',$data);
    }
}