<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pageload_hotel_dashboard($search_date)
    {
        $page_name = $this->uri->segment(1);
        $procedure = "EXEC FETCH_INFORMATION_FOR_HOTEL_DASHBOARD @USER_CODE = '" . $this->userid . "', @PAGE_NAME = '" . $page_name . "', @SEARCH_DATE = '" . $search_date . "' ";
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
}