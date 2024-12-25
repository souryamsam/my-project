<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function doLogin($user_id,$password) {
        try{
            $procedure = "EXEC SELECT_USER_AUTHENTICATION @USER_ID = '".$user_id."', @PASSWORD = '".$password."', @MENU_FOR = 'ERP', @menu_id = 'M1'";
            // echo $procedure;die;
            /* if (!$query) {
                $error = $this->db->error();
                throw new Exception("Error Processing Request: ".$error['message'], 1);
            } */
           $query = sqlsrv_query($this->db->conn_id,$procedure);
            $data = array();
            if ($query) {
                do{
                    $array = array();
                    while( $row = sqlsrv_fetch_array( $query )) {
                        $array[]=$row;
                    }
                    $data[] = $array;
                }while(sqlsrv_next_result($query));
            }
            $user_data = array_values(array_filter($data));
        
            $user_status = isset($user_data[0][0]["STATUS"])?$user_data[0][0]["STATUS"]:'1';
            $data_status = isset($user_data[1][0]["STATUS"])?$user_data[1][0]["STATUS"]:'1';
            if($data_status == '0') {
                return array("status"=>'0',"message"=>"User does not have permission to login on this portal!");
                exit;
            }
            $user_msg = isset($user_data[0][0]["MSG"])?$user_data[0][0]["MSG"]:'1';
            $user_group_data = [];
            if(!empty($user_data[2])) {
                foreach($user_data[2] as $group) {
                    if($group["MAPPING_STATUS"] == 'ACTIVE') {
                        $user_group_data[] = $group["UG_ID"];
                    }
                }
            }
            //$user_group_code = isset($user_data[2][0]["UG_ID"])?$user_data[2][0]["UG_ID"]:'';
            $user_group_code = implode(',',$user_group_data);
            if($user_status == '1') {
                if(!empty($user_data)) {
                    $user_records = isset($user_data[0][0])?$user_data[0][0]:'';
                     // user info data set
                    $fav_pages = isset($user_data[1])?$user_data[1]:array();    // page data set
                    $has_fav = count($fav_pages);
                    $user_group_codes = [];
                    if(!empty($user_data[2])) {
                        foreach($user_data[2] as $ug_row) {
                            if($ug_row["MAPPING_STATUS"] == 'ACTIVE') {
                                $user_group_codes[] = $ug_row["UG_ID"];
                            }
                        }
                    }
                    // $role_data = implode(',',$user_group_codes);
                    if(!empty($user_records)) {
                        $USERID = $user_records["USERID"];
                        $USER_CODE = $user_records["USER_CODE"];
                        $USER_TYPE = $user_records["USER_TYPE"];
                        $E_NAME = $user_records["E_NAME"];
                        $E_IMAGE = $user_records["E_IMAGE"];
                        $DEPARTMENT = $user_records["DEPARTMENT"];
                        $LOGIN_DATE_TIME = $user_records["LOGIN_DATE_TIME"];
                        $SESSION_NAME = $user_records["SESSION_NAME"];
                        $DEPARTMENT_CODES = [];
                        if($user_records["DEPARTMENT_CODES"] != "") {
                            $DEPARTMENT_CODES_ARR = explode(',',$user_records["DEPARTMENT_CODES"]);
                            for($i=0; $i < count($DEPARTMENT_CODES_ARR); $i++) {
                                $DEPARTMENT_CODES[] = $this->my_encryption->encrypt($DEPARTMENT_CODES_ARR[$i]);
                            }
                        }
                        /* $LAB_DEPARTMENT_CODES = [];
                        if($user_records["LAB_GROUP"] != "") {
                            $LAB_DEPARTMENT_CODES_ARR = explode(',',$user_records["LAB_GROUP"]);
                            for($i=0; $i < count($LAB_DEPARTMENT_CODES_ARR); $i++) {
                                $LAB_DEPARTMENT_CODES[] = $this->my_encryption->encrypt($LAB_DEPARTMENT_CODES_ARR[$i]);
                            }
                        } */
                        if($USER_TYPE == 'USER') {
                            if($has_fav > 1) {
                                $this->session->set_userdata(
                                    array(
                                        "user_status"=>'1',
                                        "user_code"=>$this->my_encryption->encrypt($USER_CODE),
                                        "user_id"=>$this->my_encryption->encrypt($user_id),
                                        "password"=>$this->my_encryption->encrypt($password),
                                        'fav_pages'=>$fav_pages,"user_group_code"=>$this->my_encryption->encrypt($user_group_code),
                                        )
                                    );

                                return redirect(base_url('login'));
                            }
                            else{
                                $this->session->unset_userdata(array("user_status","user_code"));
                                //,"fav_pages"
                                $this->session->set_userdata(array("userid"=>$this->my_encryption->encrypt($USER_CODE),"fav_Page"=>$fav_pages[0]["PAGE_NAME"],"user_data"=>array("E_NAME"=>$E_NAME,"E_IMAGE"=>$E_IMAGE,"DEPARTMENT"=>$DEPARTMENT,"DEPARTMENT_CODES"=>$DEPARTMENT_CODES,"LOGIN_DATE_TIME"=>$LOGIN_DATE_TIME,"user_group_code"=>$this->my_encryption->encrypt($user_group_code),'user_contact'=>$this->my_encryption->encrypt($USERID)),'SESSION_NAME'=>$SESSION_NAME));
                                //return redirect(base_url('dashboard'));
                                return redirect(base_url($fav_pages[0]["PAGE_NAME"]));
                                //return array("status"=>'1',"message"=>"Successfully logged in.");
                            }
                        }
                        else{
                            $this->session->set_userdata(array(array("fav_Page"=>"dashboard")));
                            return array("status"=>'0',"message"=>"User does not have permission to login on this portal!",'data'=>array("username"=>$user_id,"password"=>$this->my_encryption->encrypt($password)));
                            //return redirect(base_url('login'));
                        }
                    }
                    else{
                        $this->session->set_userdata(array("fav_Page"=>"dashboard"));
                        return array("status"=>'0',"message"=>"Incorrect User Id or password!",'data'=>array("username"=>$user_id,"password"=>$this->my_encryption->encrypt($password)));
                        //return redirect(base_url('login'));
                    }
                }
                else{
                    $this->session->set_userdata(array("fav_Page"=>"dashboard"));
                    return array("status"=>'0',"message"=>"Incorrect User Id or password!",'data'=>array("username"=>$user_id,"password"=>$this->my_encryption->encrypt($password)));
                    //return redirect(base_url('login'));
                }
            }
            else{
                $this->session->set_userdata(array("fav_Page"=>"dashboard"));
                return array("status"=>'0',"message"=>$user_msg,'data'=>array("username"=>$user_id,"password"=>$this->my_encryption->encrypt($password)));
            }
        } catch (Exception $e) {
    		exit('Error message: '.$e->getMessage());
    	}
    }

    public function saveFouritepages($postdata){
        $page_id = $this->my_encryption->decrypt($postdata["rdb_pages"]);
        $user_code = $this->my_encryption->decrypt($this->session->userdata('user_code'));
        $user_id = $this->my_encryption->decrypt($this->session->userdata('user_id'));
        $password = $this->my_encryption->decrypt($this->session->userdata('password'));
        $procedure = "EXEC INSERT_INTO_USER_FAVOURITES @USER_CODE = '".$user_code."',@PAGE_ID = '".$page_id."'";
        $query = $this->db->query($procedure);
        if($query){
            $this->doLogin($user_id,$password);
            // $this->session->set_userdata(array("userid"=>$this->my_encryption->encrypt($user_id)));
            // return redirect(base_url('dashboard'));
        }
        else{
            return array("status"=>'0',"message"=>"Incorrect User Id or password!",'data'=>array("username"=>$user_id,"password"=>$password));
        }
    }
}