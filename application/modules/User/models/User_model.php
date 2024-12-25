<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetch_only_user_records()
    {
        try {
            $user_id = $this->my_encryption->decrypt($this->session->userdata('userid'));
            $procedure = "EXEC SELECT_PROFILE_INFO @USER_CODE = '" . $user_id . "'";
            $data = [];
            $query = sqlsrv_query($this->db->conn_id, $procedure);
            if ($query) {
                do {
                    $array_data = [];
                    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                        $array_data[] = $row;
                    }
                    $data[] = $array_data;
                } while (sqlsrv_next_result($query));
                return isset($data[0]) ? $data[0] : array();
            } else {
                return false;
            }
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function userdata()
    {
        try {
            $user_id = $this->my_encryption->decrypt($this->session->userdata('userid'));
            $procedure = "EXEC SELECT_PROFILE_INFO @USER_CODE = '" . $user_id . "'";
            $data = [];
            $query = sqlsrv_query($this->db->conn_id, $procedure);
            if ($query) {
                do {
                    $array_data = [];
                    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                        $array_data[] = $row;
                    }
                    $data[] = $array_data;
                } while (sqlsrv_next_result($query));
                return $data;
            } else {
                return false;
            }
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function uploadProfileimage($profile_img, $requestpage)
    {
        try {
            return array(
                'status' => '1',
                'message' => "Your profile picture uploaded successfully"
            );
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function checkOldpassword($old_password)
    {
        try {
            $user_id = $this->my_encryption->decrypt($this->session->userdata('userid'));
            $procedure = "EXEC PASSWORD_CHECKING_FOR_USER_ID @USER_ID = '" . $user_id . "', @PASSWORD = '" . $old_password . "'";
            $query = $this->db->query($procedure);
            $row = $query->row_array();
            foreach ($row as $key => $value) {
                return $value;
            }
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function update_user_password($postdata)
    {
        try {
            return array(
                'status' => '1',
                'message' => 'Password updated successfully'
            );
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function upload_Profile_image($profile_img)
    {
        try {

            $procedure = "EXEC UPDATE_PROFILE_IMAGE @USER_CODE = '" . $this->my_encryption->decrypt($this->session->userdata('userid')) . "', @IMAGE = '" . $profile_img . "'";
            $query = $this->db->query($procedure);
            if ($query) {
                return array(
                    'status' => '1',
                    'message' => "Your profile picture uploaded successfully"
                );
            } else {
                return array(
                    'status' => '0',
                    'message' => "Something went wrong"
                );
            }

        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function update_user($currentdata)
    {
        try {
            $contact_number = $this->my_encryption->decrypt($_SESSION["user_data"]["user_contact"]);
            $procedure = "EXEC UPDATE_PROFILE_INFO @USER_CODE = '" . $currentdata['user_id'] . "', @DOB = '" . $currentdata['dob'] . "', @CONTACT_NUMBER = '" . $contact_number . "', @ALT_CONTACT_NUMBER = '" . $currentdata['alt_contact_no'] . "', @COUNTRY_CODE = '" . $currentdata['country_code'] . "',@PIN_CODE = '" . $currentdata['pin'] . "',@ADDRESS = '" . $currentdata['address'] . "',@STATE_CODE = '" . $currentdata['state_code'] . "',@IMAGE = '" . $currentdata['image'] . "',@EMAIL_ADDRESS = '" . $currentdata['email'] . "'";
            // echo $procedure;die;
            $query = $this->db->query($procedure);
            if ($query) {
                return array(
                    'status' => '1',
                    'message' => 'Successfully updated.'
                );
            } else {
                return array(
                    'status' => '0',
                    'message' => 'Something went wrong!'
                );
            }
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }

    public function change_password($old_password, $password)
    {
        try {
            $user_id = $this->my_encryption->decrypt($this->session->userdata('userid'));
            $procedure = "EXEC UPDATE_PROFILE_PASSWORD @USER_CODE = '" . $user_id . "',@OLD_PASSWORD = '" . $old_password . "',@NEW_PASSWORD = '" . $password . "'";
            $query = sqlsrv_query($this->db->conn_id, $procedure);
            if ($query) {
                $data = [];
                do {
                    $array_data = [];
                    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                        $array_data[] = $row;
                    }
                    $data[] = $array_data;
                } while (sqlsrv_next_result($query));
                $filtered_data = array_filter(array_values($data));
                if (!empty($filtered_data)) {
                    $status = isset($filtered_data[1][0]["STAT"]) ? $filtered_data[1][0]["STAT"] : (isset($filtered_data[0][0]["STAT"]) ? $filtered_data[0][0]["STAT"] : '0');
                    if ($status == '1') {
                        return array(
                            'status' => '1',
                            'message' => 'The password has been changed successfully .'
                        );
                    } elseif ($status == '0') {
                        return array(
                            'status' => '0',
                            'message' => 'The old passwod does not match correctly.'
                        );
                    } else {
                        return array(
                            'status' => '0',
                            'message' => 'Something went wrong!1'
                        );
                    }
                } else {
                    return array(
                        'status' => '0',
                        'message' => 'Something went wrong!3'
                    );
                }
            } else {
                return array(
                    'status' => '0',
                    'message' => 'Something went wrong!4'
                );
            }
        } catch (Exception $e) {
            exit('Error message: ' . $e->getMessage());
        }
    }
    public function user_master_pageload_data()
    {
        $page_name = ($this->uri->segment(1) === 'create-user' || $this->uri->segment(1) === 'User') ? 'create-user' : ' ';
        $procedure = "EXEC PAGE_LOAD_FOR_UESR_MASTER @USER_ID='" . $this->userid . "',@PAGE_NAME='" . $page_name . "'";
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
    public function user_master_insert($postdata)
    {
        $user_id = $this->my_encryption->decrypt($postdata["user_id"]);
        $user_dep_id = $this->my_encryption->decrypt($postdata["user_dep"]);
        $user_designation_id = $this->my_encryption->decrypt($postdata["user_designation"]);
        $user_country_id = $this->my_encryption->decrypt($postdata["user_country"]);
        $user_state_id = $this->my_encryption->decrypt($postdata["user_state"]);
        $user_dob = date('Y-m-d', strtotime($postdata['user_dob']));
        $set_role_arr = [];
        foreach ($postdata['set_role'] as $set_role) {
            $decrypted_role_id = $this->my_encryption->decrypt($set_role);
            $set_role_arr[] = $decrypted_role_id;
        }
        $set_role_value = implode(",", $set_role_arr);
        $procedure = "EXEC INSERT_INTO_MASTER_EMPLOYEE @USER_CODE='" . $user_id . "',@SALUTATION ='" . $postdata['user_title'] . "',@E_NAME='" . $postdata['user_name'] . "',@GENDER='" . $postdata['user_gender'] . "',@ADDRESS='" . $postdata['user_address'] . "',@STATE_CODE='" . $user_state_id . "',@COUNTRY_CODE='" . $user_country_id . "',@PIN_CODE='" . $postdata['user_pincode'] . "',@AVATAR='" . $postdata['user_photo'] . "',@DOB='" . $user_dob . "',@EMAIL_ADDRESS='" . $postdata['user_email'] . "',@CONTACT_NUMBER='" . $postdata['user_contact_no'] . "',@ALT_CONTACT_NUMBER='" . $postdata['user_alt_contact_no'] . "',@DEPARTMENT='" . $user_dep_id . "',@DESIGNATION='" . $user_designation_id . "',@ENABLE_LOGIN='',@CREATED_BY='" . $this->userid . "',@USER_GROUP='" . $set_role_value . "' ";
        // echo $procedure;die;
        $query = $this->db->query($procedure);
        if ($query) {
            if ($user_id) {
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
    public function view_user_master()
    {
        $page_name = $this->uri->segment(1);
        $procedure = "EXEC FETCH_ALL_USER_RECORDS @USER_ID='" . $this->userid . "',@PAGE_NAME='" . $page_name . "' ";
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
    public function inactive_data_view_user_master($postdata)
    {
        $user_code = $this->my_encryption->decrypt($postdata["custom_id"]);
        $procedure = "EXEC CHANGE_ACTIVE_STATUS_USER_WITH_USER_ID @USER_CODE='" . $user_code . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Data deleted successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function duplicate_checking_user_master($postdata)
    {
        $procedure = "EXEC CHECK_DUPLICATE_MOBILE_EMAIL @SEARCH_TYPE='" . $postdata['type'] . "', @SEARCH_VALUE='" . $postdata['value'] . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['STATUS'] == 'DUPPLICATE_EMAIL') {
            return array("status" => '1', "message" => "Duplicate Contact Number");
        } else if ($data[0][0]['STATUS'] == 'NOT_FOUND_DUPPLICATE_EMAIL') {
            return array("status" => '0', "message" => "NOT_FOUND_DUPPLICATE_EMAIL");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function get_single_user_master_data($postdata)
    {
        $user_id = $this->my_encryption->decrypt($postdata['custom_id']);
        $procedure = "EXEC FETCH_ONE_USER_WITH_USER_ID @USER_CODE='" . $user_id . "' ";
        // echo $procedure;die;
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

    public function pageload_user_role_master($ug_id)
    {
        $page_name = $this->uri->segment(1);
        $procedure = "EXEC PAGE_LOAD_FOR_ROLE_MASTER_PRIVILEDGE @USER_ID = '" . $this->userid . "', @PAGE_NAME = '" . $page_name . "', @UG_ID = '" . $ug_id . "' ";

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
    public function insert_update_user_role_master($postdata)
    {

        $pageArray = [];
        foreach ($postdata['page_id'] as $id) {
            $pageArray[] = [
                "PAGE_ID" => $this->my_encryption->decrypt($id)
            ];
        }
        $page_info = json_encode($pageArray);
        $privilegeArray = [];
        foreach ($postdata['privilege_id'] as $code) {
            $privilegeArray[] = [
                "PRIVILEDGE_CODE" => $this->my_encryption->decrypt($code)
            ];
        }
        $privilege = json_encode($privilegeArray);
        $user_group = isset($postdata['user_group']) ? $this->my_encryption->decrypt($postdata['user_group']) : '';
        $procedure = "EXEC INSERT_ROLE_MASTER_V1 @ROLE_NAME = '" . $postdata['role_name'] . "', @ENTRY_BY = '" . $this->userid . "', @USER_GROUP = '" . $user_group . "', @PAGE_INFO = '" . $page_info . "', @PRIVILEDGE = '" . $privilege . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => $user_group == '' ? "Saved successfully." : "Update successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function pageload_role_list_view()
    {
        $procedure = "EXEC USER_GROUP_LISTS";
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
        return $data;
    }

    public function role_name_duplicate_checking($postdata)
    {
        $procedure = "EXEC CHECK_DUPLICATE_ROLE_NAME @ROLE_NAME='" . $postdata['role_name'] . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        $data = [];
        do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $array[] = $row;
            }
            $data[] = $array;
        } while (sqlsrv_next_result($query));
        if ($data[0][0]['Status'] == 'DUPLICATE ENTRY') {
            return array("status" => '1', "message" => "This role name already exists");
        } else if ($data[0][0]['Status'] == 'NO DUPLICATE') {
            return array("status" => '0', "message" => "New role name");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
    public function update_role_master_status($postdata)
    {
        $user_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        $status = $postdata["mode"];
        $procedure = "EXEC ACTIVE_INACTIVE_USER_GROUP_ROLE @USER_ID = '" . $user_id . "', @AC_STATUS = '" . $status . "'";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            return array("status" => '1', "message" => "Status modify successfully.");
        } else {
            return array("status" => '0', "message" => "Something went wrong!");
        }
    }
}
