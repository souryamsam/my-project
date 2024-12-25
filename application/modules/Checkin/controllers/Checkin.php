<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Checkin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid'))
            return redirect(base_url('login'));

        $this->load->model('Checkin_model', 'checkin_model');
    }

    public function planned_checkin_checkout()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata["plan_value"]) && $postdata["plan_value"] == 'plan_search_value') {
            $search_date = date('Y-m-d', strtotime($postdata['date']));
        } else {
            $search_date = $this->my_encryption->decrypt($this->uri->segment(3));
        }
        $pageload_data = $this->checkin_model->pageload_planned_checkin_checkout($search_date);
        $data['planned_checkin_data'] = $pageload_data[0];
        $data["content_view"] = 'Checkin/planned_checkin';
        $this->template->base_template($data);
    }
    public function vacant_room()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata["room_vacancy"]) && $postdata["room_vacancy"] == 'room_vacancysearch_value') {
            $search_date = date('Y-m-d', strtotime($postdata['date']));
        } else {
            $search_date = $this->my_encryption->decrypt($this->uri->segment(2));
        }
        $pageload_data = $this->checkin_model->pageload_vacant_room($search_date);
        $data['vacant_room_data'] = $pageload_data[0];
        $data["content_view"] = 'Checkin/vacant_room';
        $this->template->base_template($data);
    }

    public function initiate_check_in()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $get_checkin_data = $this->checkin_model->get_room_details($postdata);
        // print_r($get_checkin_data);die;
        $data['room_data'] = $get_checkin_data[0];
        $data['booking_dates'] = $get_checkin_data[1];
        $data['booking_details'] = $get_checkin_data[2];

        $data["content_view"] = 'Checkin/initiate _check_in';
        $this->template->base_template($data);
    }

    public function room_booking_cart()
    {
        $guest_id = $_POST['guest_id'];
        $bookin_id = $_POST['bookin_id'];
        $filteredData = array_map(function ($values) {
            if (is_array($values)) {
                // Filter out empty values
                return array_values(array_filter($values, function ($value) {
                    return !empty($value);
                }));
            }
            return $values;
        }, $_POST);

        foreach ($filteredData as $key => $values) {
            if (is_array($values)) {
                $filteredData[$key] = array_values($values);
            }
        }
        // print_r($filteredData);die;
        $selected_room = array();

        foreach ($filteredData['room_id'] as $key => $val) {
            $selected_room[] = array(
                'room_id' => $filteredData['room_id'][$key],
                'room_no' => $filteredData['room_no'][$key],
                'bed_type' => $filteredData['bed_type'][$key],
                'room_category' => $filteredData['room_category'][$key],
                'room_type' => $filteredData['room_type'][$key],
                'ac_rent' => isset($filteredData['ac_rent'][$key]) ? $filteredData['ac_rent'][$key] : '0',
                'nonac_rent' => isset($filteredData['nonac_rent'][$key]) ? $filteredData['nonac_rent'][$key] : '0',
                'mattres' => isset($filteredData['mattres'][$key]) ? $filteredData['mattres'][$key] : '0',
                'extra_cost' => $filteredData['extra_cost'][$key],
                'room_date' => $filteredData['room_date'][$key],
            );
        }
        // print_r($selected_room);die;
        $this->session->set_userdata('selected_room', $selected_room);

        return redirect(base_url('customer-master/' . $guest_id . '/' . $bookin_id));
    }
    public function current_guest()
    {
        $current_guest = $this->checkin_model->pageload_current_guest_data();
        $data['current_guest_data'] = $current_guest[0];
        $data["content_view"] = 'Checkin/current_guest';
        $this->template->base_template($data);
    }
}

?>