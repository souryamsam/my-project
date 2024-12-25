<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Booking extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid'))
            return redirect(base_url(''));
        $this->load->model('Booking/Booking_model', 'booking_model');
        $this->load->model('Master/Master_model', 'master_model');
    }

    public function hotel_room_booking()
    {

        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata["search_room"]) && $postdata["search_room"] === 'search_hotel_room') {
            $search_room_data = $this->booking_model->search_hotel_room($postdata);
            $hotel_room_booking_pageload_data = $this->booking_model->hotel_room_search_pageload_data($postdata);
            $data['room_category_data'] = $hotel_room_booking_pageload_data[0];
            $data['room_type_data'] = $hotel_room_booking_pageload_data[1];
            $data['available_dates'] = isset($search_room_data[0]) ? $search_room_data[0] : [];
            $data['room_data'] = isset($search_room_data[1]) ? $search_room_data[1] : [];
        } else {
            $data['room_category_data'] = [];
            $data['room_type_data'] = [];
            $data['available_dates'] = [];
            $data['room_data'] = [];
        }
        $this->session->unset_userdata('selected_room');
        $data["content_view"] = 'Booking/hotel_room_booking';
        $this->template->base_template($data);
    }

    public function room_booking_customer_search()
    {
        if ($this->session->userdata('selected_room')) {
            $data["page_title"] = 'Hotel Room Booking';
            $data["card_title"] = 'Customer Master';
            $room_booking_pageload_data = $this->booking_model->room_booking_pageload_data();
            $data["document_type_data"] = $room_booking_pageload_data[0];
            $postdata = $this->security->xss_clean($this->input->post());
            if (isset($postdata["customer_search"]) && $postdata["customer_search"] === 'search_cutomers_details') {
                $search_customer_data = $this->booking_model->search_customers_details($postdata);
                $data["customer_search_data"] = $search_customer_data[0];
            } else {
                $data["customer_search_data"] = [];
            }
            $data["content_view"] = 'Booking/room_booking_customer_search';
            $this->template->base_template($data);
        } else {

            return redirect(base_url('hotel-room-booking'));
        }
    }



    public function room_booking_cart()
    {
        $filteredData = array_map(function ($values) {
            return array_filter($values, function ($value) {
                return !empty($value);
            });
        }, $_POST);

        foreach ($filteredData as $key => $values) {
            $filteredData[$key] = array_values($values);
        }

        $selected_room = array();

        foreach ($filteredData['room_id'] as $key => $val) {
            $selected_room[] = array(
                'room_id' => $filteredData['room_id'][$key],
                'room_no' => $filteredData['room_no'][$key],
                'bed_type' => $filteredData['bed_type'][$key],
                'room_category' => $filteredData['room_category'][$key],
                'room_type' => $filteredData['room_type'][$key],
                'ac_rent' => isset($filteredData['ac_rent'][$key]) ? $filteredData['ac_rent'][$key] : '',
                'nonac_rent' => $filteredData['nonac_rent'][$key],
                'mattres' => isset($filteredData['mattres'][$key]) ? $filteredData['mattres'][$key] : '',
                'extra_cost' => $filteredData['extra_cost'][$key],
                'room_date' => $filteredData['room_date'][$key],
            );
        }
        $this->session->set_userdata('selected_room', $selected_room);

        return redirect(base_url('room-booking'));
    }


    public function room_booking_payment_info()
    {
        $selected_room = $this->session->userdata('selected_room');
        if (!$selected_room) {
            return redirect(base_url('hotel-room-booking'));
        } else {
            $data["page_title"] = 'Hotel Room Booking';
            $data["card_title"] = 'Customer Master';
            $data["selected_room"] = $selected_room;
            $payment_info_pageload_data = $this->booking_model->payment_info_pageload();
            $data['agent_data'] = $payment_info_pageload_data[0];
            $data['payment_data'] = $payment_info_pageload_data[1];
            $data['paying_amt'] = isset($payment_info_pageload_data[2][0]) ? $payment_info_pageload_data[2][0] : '0' ;
            $data["content_view"] = 'Booking/room_booking_payment_info';
            $this->template->base_template($data);
        }
    }

    public function room_booking_register()
    {
        $data["page_title"] = 'Hotel Room Booking';
        $data["card_title"] = 'Customer Master';
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata["register_search"]) && $postdata["register_search"] == 'booking_register_search') {
            $data["search_results"] = $this->booking_model->room_booking_register_data($postdata);
        } else {
            $data["search_results"] = $this->booking_model->room_booking_register_data($postdata);
        }
        $data["content_view"] = 'Booking/room_booking_register';
        $data['booking_receipt_modal'] = 'Booking/modal/booking_receipt_modal';
        $this->template->base_template($data);
    }
    public function booking_details_view()
    {
        $booking_id = $this->uri->segment(2);
        $booking_details = $this->booking_model->view_booking_details($booking_id);
        $data['booking_details'] = $booking_details[0];
        $data["page_title"] = 'Hotel Room Booking';
        $data["card_title"] = 'Customer Master';
        $data["content_view"] = 'Booking/booking_details_view';
        $data['booking_details_view_modal'] = 'Booking/modal/booking_details_view_modal';
        $this->template->base_template($data);
    }

    public function save_payment_details()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $results = $this->booking_model->save_payment_details($postdata);
        $this->session->set_flashdata('booking_msg', $results);
        $this->session->unset_userdata('selected_room');
        return redirect(base_url('hotel-room-booking'));
    }
}