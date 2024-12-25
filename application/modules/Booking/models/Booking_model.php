<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Booking_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function search_hotel_room($postdata)
    {
        $room_category = isset($postdata['room_category']) ? $this->my_encryption->decrypt($postdata['room_category']) : '';
        $room_type = isset($postdata['room_type']) ? $this->my_encryption->decrypt($postdata['room_type']) : '';

        $check_in_date = date('Y-m-d', strtotime($postdata['check_in_date']));
        $check_out_date = date('Y-m-d', strtotime($postdata['check_out_date']));
        $procedure = "EXEC SEARCH_PAGE_FOR_VIEW_AVAILABLE_ROOM @CHECKINDATE = '" . $check_in_date . "', @CHECKOUTDATE = '" . $check_out_date . "', @NOOFADULTS = '" . $postdata['no_of_adults'] . "', @NOOFCHILDREN = '" . $postdata['no_of_childs'] . "', @ROOM_CATEGORY = '" . $room_category . "', @ROOM_TYPE = '" . $room_type . "' ";
        // echo$procedure;die;
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        $data = array_values(array_filter($data));

        return $data;

    }
    public function room_booking_pageload_data()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_CUSTOMER_SEARCH";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            $data = [];
            do {
                $array = [];
                while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $array[] = $row;
                }
                $data[] = array_values(array_filter($array));
            } while (sqlsrv_next_result($query));
        }
        return $data;
    }

    public function search_customers_details($postdata)
    {
        $document_type = $this->my_encryption->decrypt($postdata['document_type']);
        $procedure = "EXEC SEARCH_FOR_GUEST_MASTER @SEARCH_TYPE = '" . $document_type . "', @SEARCH_VALUE = '" . $postdata['document_id_no'] . "' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            $data = [];
            do {
                $array = [];
                while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $array[] = $row;
                }
                $data[] = array_values(array_filter($array));
            } while (sqlsrv_next_result($query));
        }
        return $data;
    }

    public function hotel_room_search_pageload_data()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_ROOM_SEARCH_PAGE";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        return $data;
    }
    public function room_booking_register_data($postdata)
    {
        $search_value = isset($postdata['contact_no']) && !empty($postdata['contact_no']) ? $postdata['contact_no'] : (isset($postdata['guest_name']) ? $postdata['guest_name'] : '');
        $from_date = !empty($postdata['from_date']) ? date('Y-m-d', strtotime($postdata['from_date'])) : "";
        $to_date = !empty($postdata['to_date']) ? date('Y-m-d', strtotime($postdata['to_date'])) : "";
        $search_type = isset($postdata['search']) ? $postdata['search'] : "CURRENT_DATE";
        $procedure = "EXEC PAGE_LOAD_HOTEL_ROOM_BOOKING_REGISTER @SEARCH_TYPE='" . $search_type . "' ,@SEARCH_VALUE='" . $search_value . "' ,@FDATE='" . $from_date . "' ,@TDATE='" . $to_date . "' ";
        // echo $procedure;
        // die;
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            $data = [];
            do {
                $array = [];
                while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $array[] = $row;
                }
                $data[] = array_values(array_filter($array));
            } while (sqlsrv_next_result($query));
        }
        return $data;
    }
    public function view_booking_details($book_id)
    {
        $booking_id = $this->my_encryption->decrypt($book_id);
        $procedure = "EXEC VIEW_BOOKING_DETAILS @BOOKING_ID='" . $booking_id . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            $data = [];
            do {
                $array = [];
                while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $array[] = $row;
                }
                $data[] = array_values(array_filter($array));
            } while (sqlsrv_next_result($query));
        }
        return $data;
    }

    public function payment_info_pageload()
    {
        $booking_id = $this->my_encryption->decrypt($this->uri->segment(2));
        $procedure = "EXEC PAGE_LOAD_FOR_ROOM_BOOKING_PAYMENT @BOOKING_ID = '".$booking_id."' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            $data = [];
            do {
                $array = [];
                while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $array[] = $row;
                }
                $data[] = array_values(array_filter($array));
            } while (sqlsrv_next_result($query));
        }
        return $data;
    }
    public function save_payment_details($postdata)
    {
        $customer_id = $this->my_encryption->decrypt($postdata['customer_id']);
        $agent_id = $this->my_encryption->decrypt($postdata['agent_id']);
        $booking_id = isset($postdata['booking_id']) ? $this->my_encryption->decrypt($postdata['booking_id']) : '';
        $paying_amt = isset($postdata['paying_amount'])? $postdata['paying_amount']:'0';
        $spot_check_in = isset($postdata['todaycheck']) ? $postdata['todaycheck']: 'NO';
        $booking_details_arr = [];
        foreach ($postdata['room_ids'] as $i => $room_id) {
            $booking_details_arr[] = array(
                'ROOM_ID' => $this->my_encryption->decrypt($room_id),
                'CHECK_IN_DATE' => date('Y-m-d', strtotime($postdata['check_in_date'][$i])),
                'CHECK_OUT_DATE' => date('Y-m-d', strtotime($postdata['check_out_date'][$i])),
                'B_DAYS' => $postdata['total_days'][$i],
                'EXTRA_MATTRESS' => isset($postdata['extra_mattres'][$i]) ? $postdata['extra_mattres'][$i] : '0',
                'MATTRESS_AMOUNT' => isset($postdata['mattres_amount'][$i]) ? $postdata['mattres_amount'][$i] : '0.00',
                'ROOM_TYPE' => $postdata['room_type'][$i],
                'ROOM_AMOUNT' => $postdata['room_amount'][$i]
            );
        }
        $booking_details_json = json_encode(array('book_details' => $booking_details_arr));

        $payment_mode_arr = [];
        if (isset($postdata['payment_mode']) && isset($postdata['payment_amount'])) {
            foreach ($postdata['payment_mode'] as $i => $mode) {
                $payment_mode_arr[] = array(
                    'PAYMENT_MODE' => $this->my_encryption->decrypt($mode),
                    'AMOUNT' => $postdata['payment_amount'][$i],
                );
            }
        }
        $payment_mode_json = json_encode(array('pay_details' => $payment_mode_arr));

        $procedure = "EXEC INSERT_INTO_BOOKING_DETAILS_TO_THE_RESPECTIVE_TABLES @CUSTOMER_ID = '" . $customer_id . "', @AGENT_ID = '" . $agent_id . "', @CREATED_BY = '" . $this->userid . "', @DISCOUNT_AMT = '" . $postdata['discount_amt'] . "', @ADDED_AMT = '" . $postdata['added_amt'] . "', @TOTAL_AMT = '" . $postdata['total_amt'] . "', @BOOKING_DETAILS = '" . $booking_details_json . "', @PAYMENT_DETAILS = '" . $payment_mode_json . "', @BOOKING_ID = '".$booking_id."', @SPOT_CHEK_IN = '".$spot_check_in."', @PAYING_AMT ='".$paying_amt."' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Successfully Booked.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }


}