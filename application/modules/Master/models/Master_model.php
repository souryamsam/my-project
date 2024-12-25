<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function supplier_name_insert($postdata)
    {
        $procedure = "EXEC INSERT_AND_UPDATE_IN_TBL_MASTER_VALUE @MASTER_CODE = 'RM_SER_T', @RECORD_ID = '', @RECORD_NAME = '" . $postdata['supplier_name'] . "', @DESC_1 ='', 
        @DESC_2='', @DESC_3='',@DESC_4 ='',@DESC_5='',@DESC_6='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10=''  ";
        /*$query = $this->db->query($procedure);
        if ($query) {
            return array(
                'status' => 1,
                'message' => 'Successfully created.',

            );
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }*/
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = array_values(array_filter($array));
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPLICATE_ENTRY') {
            return array("status" => '0', "message" => "Duplicate Name");
        } elseif ($data[0][0]['STATUS'] == 'NEW_ENTRY') {
            return array("status" => '1', "message" => "Successfully created");
        } else {
            return array("status" => '0', "message" => "Somthings Went Wrrong");
        }
        //return array_values(array_filter($data));
    }
    function get_supplier_master_records()
    {
        $procedure = "PAGE_LOAD_FOR_SUPPLIER_MASTER";
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
    function fetch_state_data($postdata)
    {
        $country = $this->my_encryption->decrypt($postdata['country']);
        $procedure = "EXEC FETCH_ALL_STATE_BY_COUNTRY_CODE @COUNTRY_CODE ='" . $country . "'";
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
    function fetch_district_data($postdata)
    {
        $state_code = $this->my_encryption->decrypt($postdata['state_code']);
        $procedure = "EXEC FETCH_DISTRICT_FOR_RESPECTIVE_STATE @STATE_CODE='" . $state_code . "'";
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
    function supplier_master_card_insert($postdata)
    {
        $supplier_id = $this->my_encryption->decrypt($postdata["supplier_id"]);
        $country = $this->my_encryption->decrypt($postdata['country']);
        $state = $this->my_encryption->decrypt($postdata['state']);
        $district = $this->my_encryption->decrypt($postdata['district']);
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_3', @PARENT_ID='', @SUB_RECORD_ID='" . $supplier_id . "', @RECORD_NAME='" . $postdata['supplier_shop_name'] . "',@DESC_1='" . $postdata['supplier_contact_no'] . "',@DESC_2='" . $postdata['supplier_contact_person'] . "',@DESC_3='" . $postdata['email'] . "',@DESC_4='" . $postdata['address_one'] . "',@DESC_5='" . $postdata['address_two'] . "',@DESC_6 ='" . $country . "',@DESC_7='" . $state . "',@DESC_8='" . $district . "',@DESC_9='" . $postdata['pincode'] . "',@DESC_10='',@CREATED_BY='" . $this->userid . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            if ($supplier_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }

    public function update_supplier_master_status($postdata)
    {
        $supplier_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $supplier_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function supplier_master_view()
    {
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE @MASTER_CODE = 'R_3' ";
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

    function get_supplier_data()
    {
        $procedure = "EXEC FETCH_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE  @MASTER_CODE = 'SUPPLIER' ";
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
    function get_supplier_name_data()
    {
        $procedure = "EXEC FETCH_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE  @MASTER_CODE = 'RM_SER_T' ";
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
    function department_name_insert($postdata)
    {
        $procedure = "EXEC INSERT_AND_UPDATE_IN_TBL_MASTER_VALUE @MASTER_CODE = 'DEPT', @RECORD_ID = '', @RECORD_NAME = '" . $postdata['department_name'] . "', @DESC_1 ='', 
        @DESC_2='', @DESC_3='',@DESC_4 ='',@DESC_5='',@DESC_6='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10=''  ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = array_values(array_filter($array));
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPLICATE_ENTRY') {
            return array("status" => '0', "message" => "Duplicate Name");
        } elseif ($data[0][0]['STATUS'] == 'NEW_ENTRY') {
            return array("status" => '1', "message" => "Successfully created");
        } else {
            return array("status" => '0', "message" => "Somthings Went Wrrong");
        }
    }
    function get_department_name_data()
    {
        $procedure = "EXEC FETCH_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE  @MASTER_CODE = 'DEPT' ";
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
    /* --end-- */
    function user_master_insert($postdata)
    {
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_EMPLOYEE, @E_NAME = '" . $postdata['user_name'] . "', @CONTACT_NUMBER ='" . $postdata['contact_no'] . "', 
        @DOB='" . $postdata['dob'] . "', @EMAIL_ADDRESS='" . $postdata['email'] . "',@PRESENT_ADDRESS ='" . $postdata['address'] . "',@PARMANENT_ADDRESS='" . $postdata['p_address'] . "',@DEPARTMENT='" . $postdata['dep'] . "',@USER_ROLE='" . $postdata['user_role'] . "',@AVATAR='" . $postdata['profile_picture'] . "',@AADHAR='" . $postdata['aadhaarno'] . "',@AADHAR_DOCUMENT='" . $postdata['aadhaar_photo'] . "',@PAN_NO='" . $postdata['pan_no'] . "',@PAN_DOCUMENT='" . $postdata['pan_photo'] . "'  ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = array_values(array_filter($array));
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPLICATE_ENTRY') {
            return array("status" => '0', "message" => "Duplicate Name");
        } elseif ($data[0][0]['STATUS'] == 'NEW_ENTRY') {
            return array("status" => '1', "message" => "Successfully created");
        } else {
            return array("status" => '0', "message" => "Somthings Went Wrrong");
        }
    }
    function get_user_master_records()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_USER";
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

    public function get_single_supplier_item_data($supplier_id)
    {
        $supplier_id = $this->my_encryption->decrypt($supplier_id);
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_RECORD_ID @RECORD_ID = '" . $supplier_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function bed_type_master_insert($postdata)
    {
        $bed_id = $this->my_encryption->decrypt($postdata["bed_id"]);
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_4', @PARENT_ID='', @SUB_RECORD_ID='" . $bed_id . "', @RECORD_NAME='" . $postdata['bed_type'] . "',@DESC_1='',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6 ='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY=''";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            if ($bed_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    public function get_single_bad_data($bed_id)
    {
        $bed_id = $this->my_encryption->decrypt($bed_id);
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_RECORD_ID @RECORD_ID = '" . $bed_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function update_bed_type_master_status($postdata)
    {
        $bed_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $bed_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    function bed_type_master_view()
    {
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE @MASTER_CODE = 'R_4' ";
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
    function room_category_master_insert($postdata)
    {
        $room_id = $this->my_encryption->decrypt($postdata["room_id"]);
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_5', @PARENT_ID='', @SUB_RECORD_ID='" . $room_id . "', @RECORD_NAME='" . $postdata['room_cate'] . "',@DESC_1='',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6 ='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY=''";

        $query = sqlsrv_query($this->db->conn_id, $procedure);

        if ($query) {
            if ($room_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }

    public function get_single_room_data($room_id)
    {
        $room_id = $this->my_encryption->decrypt($room_id);
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_RECORD_ID @RECORD_ID = '" . $room_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function update_room_category_master_status($postdata)
    {
        $room_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $room_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    function room_category_master_view()
    {
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE @MASTER_CODE = 'R_5' ";
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
    function get_block_wise_floor_master_records()
    {
        $procedure = "PAGE_LOAD_FOR_BLOCK_WISE_FLOOR_MASTER";
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
    function block_wise_floor_master_insert($postdata)
    {
        $block_name_id = $this->my_encryption->decrypt($postdata["block_name"]);
        $block_id = $this->my_encryption->decrypt($postdata["block_id"]);
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_7', @PARENT_ID='" . $block_name_id . "', @SUB_RECORD_ID='" . $block_id . "', @RECORD_NAME='" . $postdata['floor_name'] . "',@DESC_1='',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6 ='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY=''";
        $query = sqlsrv_query($this->db->conn_id, $procedure);

        if ($query) {
            if ($block_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    function block_wise_floor_master_view()
    {
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE @MASTER_CODE = 'R_7' ";
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
    public function update_block_wise_floor_master_status($postdata)
    {
        $block_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $block_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function get_block_wise_floor_master_data($block_id)
    {
        $block_id = $this->my_encryption->decrypt($block_id);
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_RECORD_ID @RECORD_ID = '" . $block_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function pageload_item_category_master()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_ITEM_CATEGORY_MASTER";
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
    public function item_category_master_card_insert($postdata)
    {
        $parent_category_id = $this->my_encryption->decrypt($postdata["pa_category"]);
        $record_id = $this->my_encryption->decrypt($postdata["edit_id"]);
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE_FOR_ITEM_CATEGORY @MASTER_CODE='R_100',@PARENT_ID='" . $parent_category_id . "',@RECORD_ID='" . $record_id . "',@RECORD_NAME='" . $postdata['child_category'] . "',@DESC_1='',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY='" . $this->userid . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            if ($record_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    function item_category_master_view()
    {
        $procedure = "EXEC VIEW_CATEGORY_REGISTER";
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
    public function get_single_item_category_master_data($item_id)
    {
        $item_id = $this->my_encryption->decrypt($item_id);
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_RECORD_ID @RECORD_ID = '" . $item_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function update_item_category_master_master_status($postdata)
    {
        $item_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $item_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['INFORM'] == 'CHILD_EXISTS') {
            return array("status" => '0', "message" => "Child Already Exists");
        } elseif (!empty($data)) {
            return array("status" => '1', "message" => "Successfully Deleted");
        } else {
            return array("status" => '0', "message" => "Somthings Went Wrrong");
        }
    }
    public function room_amenities_master_insert($postdata)
    {
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_11', @PARENT_ID='', @SUB_RECORD_ID='', @RECORD_NAME='" . $postdata['amenities'] . "',@DESC_1='',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6 ='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY=''";
        $query = $this->db->query($procedure);
        if ($query) {
            return array(
                'status' => 1,
                'message' => 'Successfully created.',
            );
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }

    public function room_master_pageload_data()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_ROOM_MASTER";
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

    public function check_duplicate_room_no($room_no)
    {
        $procedure = "EXEC DUPLICATE_CHECKING @CHECK_TYPE = 'ROOM', @CHECK_VALUE = '" . $room_no . "' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        print_r($data);
        die;
        return $data;
    }
    public function save_room_master_record($postdata)
    {
        foreach ($postdata as $key => $value) {
            $postdata[$key] = str_replace("'", "''", $value);
        }

        $block_no = $this->my_encryption->decrypt($postdata["block_no"]);

        $floor_no = $this->my_encryption->decrypt($postdata["floor_no"]);

        $room_category = $this->my_encryption->decrypt($postdata["room_category"]);

        $room_type = $this->my_encryption->decrypt($postdata["room_type"]);

        $bed_type = $this->my_encryption->decrypt($postdata["bed_type"]);

        $room_id = $this->my_encryption->decrypt($postdata["room_id"]);

        $extra_cost = ($postdata["extra_cost"] != '') ? $postdata["extra_cost"] : '0.00';

        $ac_price = ($postdata['room_price_ac'] != '') ? $postdata['room_price_ac'] : '0.00';

        $non_ac_price = ($postdata['room_price_nonac'] != '') ? $postdata['room_price_nonac'] : '0.00';


        if (isset($postdata['room_photo'])) {
            $room_photo_arr = [];
            foreach ($postdata['room_photo'] as $photo_name) {
                $photo_name = $photo_name;
                $room_photo_arr[] = array(
                    "PHOTO_ID" => '',
                    "PHOTO_NAME" => $photo_name,
                    "PHOTO_STATUS" => 'ACTIVE',
                );
            }
        }
        $room_photo = json_encode(array('rm_photos' => $room_photo_arr));
        $amenities_arr = [];
        foreach ($postdata['amenities'] as $amenity) {
            $decrypted_amenity = $this->my_encryption->decrypt($amenity);
            $amenities_arr[] = $decrypted_amenity;
        }
        $amenities = implode(",", $amenities_arr);

        $procedure = "EXEC INSERT_INTO_TBL_ROOM_MASTER @ROOMID = '" . $room_id . "', @BLOCKNO = '" . $block_no . "', @FLOORNO = '" . $floor_no . "', @ROOMNO = '" . $postdata['room_no'] . "', @ROOMSIZE = '" . $postdata['room_size'] . "', @ROOMCATEGORY = '" . $room_category . "', @ROOMTYPE = '" . $room_type . "', @GUESTCAPACITY = '" . $postdata['guest_capacity'] . "', @BEDTYPE = '" . $bed_type . "', @AC_ROOM_PRICE = '" . $ac_price . "', @NON_AC_ROOM_PRICE = '" . $non_ac_price . "', @EXTRAGUEST = '" . $postdata['extra_guests'] . "', @EXTRACOST = '" . $extra_cost . "', @ROOMAMENITIES = '" . $amenities . "', @ROOMDESCRIPTION = '" . $postdata['room_desc_val'] . "', @RM_PHOTOS = '" . $room_photo . "' ";
        $query = $this->db->query($procedure);
        if ($query) {
            return array(
                'status' => 1,
                'message' => 'Successfully created.',

            );
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    public function get_single_room_master_data($room_id)
    {
        $room_id = $this->my_encryption->decrypt($room_id);
        $procedure = "EXEC VIEW_PAGE_FOR_TBL_ROOM_MASTER_BY_ROOM_ID @ROOM_ID = '" . $room_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function room_master_view()
    {
        $procedure = "EXEC VIEW_PAGE_FOR_TBL_ROOM_MASTER";
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
    public function update_room_master_status($postdata)
    {
        $room_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS_FOR_ROOM_MASTER @ROOM_ID = '" . $room_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function item_master_pageload()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_ITEM_MASTER";
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
    public function fetch_item_category_data($postdata)
    {
        $item_category = $this->my_encryption->decrypt($postdata['item_category']);
        $procedure = "EXEC FETCH_ITEM_CATEGORY_AGAINEST_MASTER_ITEM @ITEM_TYPE='" . $item_category . "'";
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
    public function item_master_uom_insert($postdata)
    {
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_13', @PARENT_ID='', @SUB_RECORD_ID='', @RECORD_NAME='" . $postdata['uom'] . "',@DESC_1='',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6 ='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY='" . $this->userid . "'";
        $query = $this->db->query($procedure);
        if ($query) {
            return array(
                'status' => 1,
                'message' => 'UOM Successfully created.',

            );
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    public function item_master_manufacturer_insert($postdata)
    {
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_14', @PARENT_ID='', @SUB_RECORD_ID='', @RECORD_NAME='" . $postdata['manufacturer_name'] . "',@DESC_1='" . $postdata['manufacturer_address'] . "',@DESC_2='',@DESC_3='',@DESC_4='',@DESC_5='',@DESC_6 ='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY='" . $this->userid . "'";
        $query = $this->db->query($procedure);
        if ($query) {
            return array(
                'status' => 1,
                'message' => 'Manufacturer Successfully created.',

            );
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    public function item_master_card_insert($postdata)
    {
        $record_id = $this->my_encryption->decrypt($postdata["record_id"]);
        // $item_type_id = $this->my_encryption->decrypt($postdata["item_type"]);
        $item_category_id = $this->my_encryption->decrypt($postdata["item_category_name"]);
        $uom_id = $this->my_encryption->decrypt($postdata["uom"]);
        $manufacturer_id = $this->my_encryption->decrypt($postdata["manufacturer"]);

        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE_FOR_ITEM_CATEGORY @MASTER_CODE='R_100',@PARENT_ID='" . $item_category_id . "',@RECORD_ID='" . $record_id . "',@RECORD_NAME='" . $postdata['item_name'] . "',@DESC_1='" . $postdata['item_details'] . "',@DESC_2='" . $uom_id . "',@DESC_3='" . $manufacturer_id . "',@DESC_4='',@DESC_5='',@DESC_6='',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY='" . $this->userid . "'";
        $query = $this->db->query($procedure);
        if ($query) {
            if ($record_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    public function item_master_card_view($postdata)
    {
        $search_type = isset($postdata["search_type"]) ? $postdata["search_type"] : 'ALL';
        $search_value = isset($postdata["search_value"]) ? $this->my_encryption->decrypt($postdata["search_value"]) : '';
        $search_item_type = isset($postdata["item_type"]) ? $this->my_encryption->decrypt($postdata["item_type"]) : '';
        $search_item_category = isset($postdata["item_category"]) && $postdata["item_category"] != '' ? $this->my_encryption->decrypt($postdata["item_category"]) : 'ALL';
        $search_value_param = $search_value ? $search_value : ($search_item_type ? $search_item_type : '');
        $procedure = "EXEC VIEW_PAGE_FOR_ITEM_MASTER @SEARCH_TYPE='" . $search_type . "',@SEARCH_VALUE='" . $search_value_param . "', @ITEM='" . $search_item_category . "' ";
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
    public function get_single_item_master_data($record_id)
    {
        $record_id = $this->my_encryption->decrypt($record_id);
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_RECORD_ID @RECORD_ID = '" . $record_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function update_item_master_status($postdata)
    {
        $item_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $item_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['INFORM'] == 'CHILD_EXISTS') {
            return array("status" => '0', "message" => "Child Already Exists");
        } elseif (!empty($data)) {
            return array("status" => '1', "message" => "Status modify");
        } else {
            return array("status" => '0', "message" => "Somthings Went Wrrong");
        }
    }

    public function agent_master_insert($postdata, $file_paths)
    {
        $agent_id = $this->my_encryption->decrypt($postdata["agent_id"]);
        $agent_document_id = $this->my_encryption->decrypt($postdata["d_type"]);
        $photo_names = implode(",", $file_paths);
        $procedure = "EXEC INSERT_INTO_TBL_MASTER_VALUE  @RECORD_ID='R_16', @PARENT_ID='', @SUB_RECORD_ID='" . $agent_id . "', @RECORD_NAME='" . $postdata['agent_name'] . "',@DESC_1='" . $postdata['mobile_number'] . "',@DESC_2='" . $postdata['email'] . "',@DESC_3='" . $postdata['address'] . "',@DESC_4='" . $agent_document_id . "',@DESC_5='" . $postdata['d_no'] . "',@DESC_6 ='" . $photo_names . "',@DESC_7='',@DESC_8='',@DESC_9='',@DESC_10='',@CREATED_BY='" . $this->userid . "'";
        $query = $this->db->query($procedure);
        if ($query) {
            if ($agent_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    function agent_master_master_view()
    {
        $procedure = "EXEC SELECT_ALL_FROM_TBL_MASTER_VALUE_BY_MASTER_CODE @MASTER_CODE = 'R_16' ";
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
    public function update_agent_master_status($postdata)
    {
        $agent_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC UPDATE_ACTIVE_STATUS @RECORD_ID = '" . $agent_id . "', @A_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function get_single_agent_master_data($agent_id)
    {
        $agent_id = $this->my_encryption->decrypt($agent_id);
        $procedure = "EXEC VIEW_PAGE_FOR_ITEM_MASTER_BY_RECORD_ID @RECORD_ID = '" . $agent_id . "' ";
        $query = $this->db->query($procedure);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function customer_master_pageload_data()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_CUSTOMER";
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
    public function customer_master_card_insert($postdata, $file_paths)
    {

        $guest_id = $this->my_encryption->decrypt($postdata['guest_id']);
        $country = $this->my_encryption->decrypt($postdata['country']);
        $state = $this->my_encryption->decrypt($postdata['state']);
        $city = $this->my_encryption->decrypt($postdata['city']);
        $document_id = $this->my_encryption->decrypt($postdata['id_document_type']);
        $dob = ($postdata['dob'] != '') ? date('Y-m-d', strtotime($postdata['dob'])) : '';
        $doa = ($postdata['doa'] != '') ? date('Y-m-d', strtotime($postdata['doa'])) : '';

        $document_data_arr = [];
        $photo_names = implode(",", $file_paths);
        $photos = implode(",", $postdata['doc_photo']);
        $document_data_arr = array(
            'DOC_ID' => '',
            'IDENTITY_NUMBER' => $postdata['id_no'],
            'DOC_TYPE' => $document_id,
            'DOC_NAME' => ($photo_names != '') ? $photo_names : $photos,
            'DOC_STATUS' => 'ACTIVE'
        );

        $document = json_encode(array('rm_docs' => $document_data_arr));

        $relation_details_arr = [];
        if (isset($postdata['co_document_type'])) {
            foreach ($postdata['co_document_type'] as $i => $document_type) {
                $relation_details_arr[] = array(
                    'DOC_ID' => '',
                    'IDENTITY_NUMBER' => $postdata['co_name'][$i],
                    'DOC_TYPE' => $this->my_encryption->decrypt($document_type),
                    'DOC_NAME' => $postdata['co_file'][$i],
                    'DOC_STATUS' => 'ACTIVE',
                    'RELATION' => $postdata['relationship'][$i],
                );
            }
        }
        $relation_details_json = json_encode(array('relation_docs' => $relation_details_arr));

        $procedure = "EXEC INSERT_INTO_TBL_GUEST_MASTER @GUEST_ID='" . $guest_id . "', @CONTACT_NO='" . $postdata['mobile'] . "',@ALT_CONTACT_NO='" . $postdata['alt_contact_no'] . "',@EMAIL_ADDRESS='" . $postdata['email'] . "',@GUEST_NAME='" . $postdata['customer_name'] . "',@DOB='" . $dob . "',@DOA='" . $doa . "',@ADDRESS_1='" . $postdata['address_one'] . "',@ADDRESS_2='" . $postdata['address_two'] . "',@CITY='" . $city . "', @STATE='" . $state . "',@COUNTRY='" . $country . "', @PIN_CODE='" . $postdata['pincode'] . "',@COMPANY_NAME='" . $postdata['company_name'] . "',@GSTIN='" . $postdata['gst'] . "',@CREATED_BY='" . $this->userid . "',@RM_DOCS = '" . $document . "', @RELATION_DOCS = '" . $relation_details_json . "' ";
        // echo $procedure;
        // die;
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

        $GUEST_ID = $data[0][0]['GUEST_ID'];
        if ($data[0][0]['STATUS'] == 'SUCCESS_INSERT') {
            return array("status" => '1', "message" => "Sucessfully Saved", "GUEST_ID" => $GUEST_ID);
        } else if ($data[0][0]['STATUS'] == 'SUCCESS_UPDATE') {
            return array("status" => '1', "message" => "Sucessfully Update", "GUEST_ID" => $GUEST_ID);
        } else {
            return array("status" => '0', "message" => "Somthing Wrrong !");
        }
    }
    public function get_single_customer_data($customer_id)
    {
        $customer_id = isset($customer_id) ? $this->my_encryption->decrypt($customer_id) : '';

        $procedure = "EXEC VIEW_PAGE_FOR_GUEST @GUEST_ID = '" . $customer_id . "' ";
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
    public function restaurant_menu_master_pageload_data()
    {
        $procedure = "EXEC PAGE_LOAD_FOR_RESTURENT_MENU_MASTER";
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
    public function fetch_unit_data($postdata)
    {
        $ingredients_name_id = $this->my_encryption->decrypt($postdata['ingredients_name']);
        $procedure = "EXEC FETCH_UNIT_FOR_ITEM @ITEM_CODE='" . $ingredients_name_id . "'";
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
    public function restaurant_menu_master_insert($postdata)
    {
        $dish_id = $this->my_encryption->decrypt($postdata['dish_id']);
        $dish_category_id = $this->my_encryption->decrypt($postdata['dis_caregory']);
        $dish_name = strtoupper($postdata['dish_name']);
        $ingredients = array();
        foreach ($postdata['ingredients_name'] as $index => $ingredient_name) {
            $Ingredients_id_name = $this->my_encryption->decrypt($ingredient_name);
            $ingredients[] = array(
                'INGREDIENT_NAME' => $Ingredients_id_name,
                'INGREDIENT_ID' => '',
                'QTY_PER_DISH' => $postdata['qty_per_dish'][$index],
                'UNIT' => $postdata['unit'][$index]
            );
        }
        $ingredients_json = json_encode(array('ingredients' => $ingredients));
        $procedure = "EXEC SP_SAVE_RECIPE @DISH_ID='" . $dish_id . "', @DISH_CATEGORY='" . $dish_category_id . "', @DISH_NAME='" . $dish_name . "', @DISH_PRICE='" . $postdata['dish_price'] . "', @DISH_DESCRIPTION='" . $postdata['description'] . "', @CREATED_BY='" . $this->userid . "', @INGREDIENTS_JSON='" . $ingredients_json . "'";
        $query = $this->db->query($procedure);
        if ($query) {
            if ($dish_id) {
                return array(
                    'status' => 1,
                    'message' => 'Successfully modify.',
                );
            } else {
                return array(
                    'status' => 1,
                    'message' => 'Successfully created.',
                );
            }
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong!',
            );
        }
    }
    function restaurant_master_view()
    {
        $procedure = "EXEC VIEW_FOR_RESTURENT_MENU";
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
    public function get_single_restaurant_master_data($postdata)
    {
        $dish_id = $this->my_encryption->decrypt($postdata['custom_id']);
        $procedure = "EXEC FETCH_FOR_RESTURENT_MENU_BY_DISH_ID @DISH_ID='" . $dish_id . "' ";
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
    public function update_restaurant_master_status($postdata)
    {
        $dish_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC CHANGE_STATUS_OF_RESTAURENT_MENU @DISH_ID = '" . $dish_id . "', @STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }

    public function duplicate_check($postdata)
    {
        $procedure = "EXEC CHECK_DUPLICATE_FOR_GUEST @CHECK_TYPE = '" . $postdata['type'] . "', @CHECK_VALUE = '" . $postdata['value'] . "' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPLICATE_CONTACT') {
            return array("status" => '1', "message" => "Duplicate Contact Number");
        } else if ($data[0][0]['STATUS'] == 'DUPLICATE_GSTIN') {
            return array("status" => '1', "message" => "Duplicate GST Number");
        } else if ($data[0][0]['STATUS'] == 'DUPLICATE_IDENTITY') {
            return array("status" => '1', "message" => "Duplicate Idebtity Number");
        } else {
            return array("status" => '0', "message" => "Somthing Wrrong !");
        }
    }
    public function floor_name_duplicate_check_in_block_wise_floor_master($postdata)
    {
        $block_id = $this->my_encryption->decrypt($postdata['block_name']);
        $procedure = "EXEC DUPLICATE_CHECKING_FOR_FLOOR @BLOCK = '" . $block_id . "', @FLOOR = '" . $postdata['floor_name'] . "' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPLICATE') {
            return array("status" => '1', "message" => "Duplicate floor name found");
        } else if ($data[0][0]['STATUS'] == 'NEW') {
            return array("status" => '0', "message" => "New floor name");
        } else {
            return array("status" => '0', "message" => "Somthing Wrrong");
        }
    }
    public function room_number_duplicate_check_in_room_master($postdata)
    {
        $procedure = "EXEC DUPLICATE_CHECKING @CHECK_TYPE = 'ROOM', @CHECK_VALUE = '" . $postdata['room_number'] . "' ";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPLICATE_ENTRY') {
            return array("status" => '1', "message" => "Duplicate room number found");
        } else if ($data[0][0]['STATUS'] == 'NEW_ENTRY') {
            return array("status" => '0', "message" => "New Entry");
        } else {
            return array("status" => '0', "message" => "Somthing Wrrong");
        }
    }
    public function fetch_item_master_view_page_load_data($postdata)
    {
        $procedure = "EXEC PAGE_LOAD_FOR_ITEM_REGISTER @LIST_NAME='" . $postdata['search_type'] . "'";
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