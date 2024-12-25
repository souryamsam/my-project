<?php
class Menu_model extends MY_Model{
    function __construct() {
        parent::__construct();
    }

    public function get_page_title($slug_name) {
        $pages = array();
        if($this->session->userdata("pages")){
            $pages = $this->session->userdata("pages");
            if(!empty($pages)) {
                foreach($pages as $prow) {
                    if($prow["PAGE_NAME"] == $slug_name) {
                        $pages = array("PAGE_APP_NAME"=>$prow["PAGE_APP_NAME"],"ICON"=>$prow["ICON"],"ICON_COLOR"=>$prow["ICON_COLOR"]);
                    }
                }
            }
        }
        return $pages;
    }

    public function registered_menus($side="") {
        $user_group_code = $this->my_encryption->decrypt($_SESSION["user_data"]["user_group_code"]);
        $procedure = "EXEC MENU_BIND @MENU_FOR = 'ERP',@USER_GROUP_CODE='$user_group_code'";
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

    function menu_bind($side){
        $menu_li = '';
        if(!$this->session->userdata("menus")){
            $left_menus = $this->registered_menus($side);
            $this->session->set_userdata("menus",$left_menus);
        }
        if(!$this->session->userdata("pages")){
            $all_pages = $this->registered_menus();
            $this->session->set_userdata("pages",$all_pages);
        }
        if($this->session->userdata("menus")){
            $menus = $this->session->userdata("menus");
            if(!empty($menus)) {
                foreach($menus as $mrow) {
                    $menu_li .= '<li class="treeview">';
                    $menu_li .= '<a href="#">';
                    $menu_li .= '<i class="'.$mrow["MENU_ICON"].'" style="color:'.$mrow["MENU_ICON_COLOR"].';"></i><span>'.$mrow["MENU_NAME"].'</span>';
                    $menu_li .= '</a>';
                    $menu_li .= '<ul class="treeview-menu">';
                    foreach($mrow["MENU_PAGES"] as $prow) {
                        $active_status = ($this->uri->segment(1)==$prow["PAGE_NAME"])?"active":"";
                        $menu_li .= '<li class="'.$active_status.'"><a href="'.base_url($prow["PAGE_NAME"]).'"><i class="'.$prow["ICON"].'" style="color:'.$prow["ICON_COLOR"].'"></i>'.$prow["PAGE_APP_NAME"].'</a></li>';
                    }
                    $menu_li .= '</ul>';
                        
                    $menu_li .= '</li>';
                }
            }
        }
        return $this->my_encryption->encrypt($menu_li);
    }

    public function get_Page_header_name($page_slug) {
        if($this->session->userdata("menus")){
            $menus = $this->session->userdata("menus");
            if(!empty($menus)) {
                foreach($menus as $mrow) {
                    foreach($mrow["MENU_PAGES"] as $prow) {
                        if($prow["PAGE_NAME"] == $page_slug) {
                            $selected_pages = array(
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
                }
            }
        }

        //return !empty($selected_pages)?$selected_pages["PAGE_HEADER_NAME"]:"";
        return !empty($selected_pages)?'<h1><i class="'.$selected_pages["ICON"].'" style="color:'.$selected_pages["ICON_COLOR"].'"></i>'.$selected_pages["PAGE_HEADER_NAME"].'</h1>':"";
    }
}
?>