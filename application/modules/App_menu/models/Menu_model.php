<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    public function registered_menus($side="") {
        $user_group_code = $this->my_encryption->decrypt($_SESSION["user_data"]["user_group_code"]);
        $procedure = "EXEC MENU_BIND @MENU_FOR = 'ERP',@USER_GROUP_CODE='UG_1'";
        echo $procedure;die;
        $query = sqlsrv_query($this->db->conn_id,$procedure);
        $data = array();
        if ($query) {
            do{
                $array = array();
                while( $row = sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC )) {
                    $array[]=$row;
                }
                $data[] = $array;
            }while(sqlsrv_next_result($query));
        }
        $menu_data = array_values(array_filter($data));
        $menus_arr = isset($menu_data[0])?$menu_data[0]:[];
        $pages_arr = isset($menu_data[1])?$menu_data[1]:[];
        $final_menus = [];
        $all_pages = [];
        if(!empty($menus_arr)) {
            foreach($menus_arr as $mrow){
                if($mrow["MENU_LOCATION"] == $side) {
                    $mpages = [];
                    foreach($pages_arr as $prow) {
                        if($prow["MENU_ID"] == $mrow["MENU_ID"]) {
                            $mpages[] = array(
                                "PAGE_ID"=>$prow["PAGE_ID"],
                                "MENU_ID"=>$prow["MENU_ID"],
                                "PAGE_NAME"=>$prow["PAGE_NAME"],
                                "PAGE_APP_NAME"=>$prow["PAGE_APP_NAME"],
                                "PAGE_HEADER_NAME"=>$prow["PAGE_HEADER_NAME"],
                                "PARAMETERS"=>$prow["PARAMETERS"],
                                "ICON"=>$prow["ICON"],
                                "ICON_COLOR"=>$prow["ICON_COLOR"],
                                "DISPLAY_SEQUENE"=>$prow["DISPLAY_SEQUENE"],
                                "CURRENT_STATUS"=>$prow["CURRENT_STATUS"],
                                "PARAMETERS_VALUE"=>$prow["PARAMETERS_VALUE"]
                            );
                        }
                    }
    
                    $final_menus[] = array(
                        "MENU_ID"=>$mrow["MENU_ID"],
                        "MENU_NAME"=>$mrow["MENU_NAME"],
                        "MENU_ICON"=>$mrow["MENU_ICON"],
                        "MENU_ICON_COLOR"=>$mrow["MENU_ICON_COLOR"],
                        "MENU_LOCATION"=>$mrow["MENU_LOCATION"],
                        "MENU_PAGES"=>$mpages
                    );
                }
            }
        }

        if(!empty($pages_arr)) {
            foreach($pages_arr as $prow) {
                $all_pages[] = array(
                    "PAGE_ID"=>$prow["PAGE_ID"],
                    "MENU_ID"=>$prow["MENU_ID"],
                    "PAGE_NAME"=>$prow["PAGE_NAME"],
                    "PAGE_APP_NAME"=>$prow["PAGE_APP_NAME"],
                    "PAGE_HEADER_NAME"=>$prow["PAGE_HEADER_NAME"],
                    "PARAMETERS"=>$prow["PARAMETERS"],
                    "ICON"=>$prow["ICON"],
                    "ICON_COLOR"=>$prow["ICON_COLOR"],
                    "DISPLAY_SEQUENE"=>$prow["DISPLAY_SEQUENE"],
                    "CURRENT_STATUS"=>$prow["CURRENT_STATUS"],
                    "PARAMETERS_VALUE"=>$prow["PARAMETERS_VALUE"]
                );
            }
        }

        if($side != "") {
            return $final_menus;
        }
        else{
            return $all_pages;
        }
    }
    
}