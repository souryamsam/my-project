<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid'))
            return redirect(base_url('login'));
        $this->load->model('User/User_model', 'user_model');
        $this->load->model('Dashboard/Dashboard_model', 'dashboard_model');
        $this->users = $this->user_model->userdata();
    }

    public function index()
    {
        $data["content_view"] = 'Dashboard/dashboard_v1';
        $this->template->base_template($data);
    }

    public function hotel_dashboard()
    {

        $postdata = $this->security->xss_clean($this->input->post());
        
        if (isset($postdata["hotel_dashboard"]) && $postdata["hotel_dashboard"] === 'hotel_dashboard_search_flag') {
            $search_date = date('Y-m-d', strtotime($postdata['search_date']));
        } else {
            $search_date = date('Y-m-d');
        }
        
        $pageload_data = $this->dashboard_model->pageload_hotel_dashboard($search_date);
        if ($pageload_data[0][0]['STATUS'] == 'NO')
            return redirect(base_url("access-denied"));

        $data['hotel_dashboard_count'] = $pageload_data[1][0];
        $data['dashboard_customer_data'] = $pageload_data[2];

        $data["content_view"] = 'Dashboard/hotel_dashboard.php';
        $this->template->base_template($data);
    }

}