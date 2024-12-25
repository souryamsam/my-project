<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Checkin_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function pageload_planned_checkin_checkout($search_date)
    {
        $search_type = $this->my_encryption->decrypt($this->uri->segment(2));
        $search_date = date('Y-m-d', strtotime($search_date));
        $procedure = "EXEC PLANNED_CHECKED_IN_REPORT_FOR_SPECIFIC_DATE @SEARCH_TYPE = '" . $search_type . "', @SEARCH_DATE = '" . $search_date . "' ";
        // echo $procedure;die;
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

    public function pageload_vacant_room($search_date)
    {
        $search_date = date('Y-m-d', strtotime($search_date));
        $procedure = "EXEC ROOM_VACANCY_REPORT_FOR_SPECIFIC_DATE @SEARCH_DATE = '" . $search_date . "' ";
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

    public function get_room_details($postdata)
    {
        $booking_id = isset($postdata['custom_id']) ? $this->my_encryption->decrypt($postdata['custom_id']) : '';
        $customer_id = isset($postdata['guest_id']) ? $this->my_encryption->decrypt($postdata['guest_id']) : '';

        $procedure = "EXEC FETCH_FOR_GUEST_CHECK_IN_EDIT_PAGE @BOOKING_ID = '" . $booking_id . "', @CUSTOMER_ID = '" . $customer_id . "' ";

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
    public function pageload_current_guest_data()
    {
        $procedure = "EXEC TODAYS_CHECKED_IN_REPORT_FOR";
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
}
?>