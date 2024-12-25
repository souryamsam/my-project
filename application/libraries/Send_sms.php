<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
class Send_sms {
    private $CI;
    public function __construct() {
        $this->CI =& get_instance();
        //$this->CI->load->database();
    }

    public function get_sms_templates($sms_type) {
        $procedure = "EXEC CNCI_OT_GET_SMS_TEMPLATE_BY_TYPE @sms_type = '".$sms_type."'";
        $query = $this->CI->db->query($procedure);
        if($query->num_rows() != 0) {
            return $query->row();
        }
        else{
            return false;
        }
    }

    public function sendOTMessage($to_mobile,$sms_type,$sms_records) {
        $templates = $this->get_sms_templates($sms_type);
        if(!empty($templates) && $templates != false) {
            $api_url = $templates->URL;
            $api_user = $templates->USERNAME;
            $api_pass = $templates->PASSWORD;
            $api_service = $templates->SERVICE;
            $api_sender = $templates->SENDER;
            $api_teid = $templates->TEMPLATE_ID;
            $message = $templates->SMS_TEMPLATE;
            if($templates->SMS_ENV == 'TESTING') {
                $mobile_no = $templates->TESTING_MOBILE_NO;
            }
            else{
                $mobile_no = $to_mobile;
            }
            $message_arr = explode("{#var#}",$message);
            $final_message = '';
            if(!empty($message_arr)) {
                for($m=0; $m < count($message_arr); $m++) {
                    if($m != count($message_arr)-1) {
                        $suffix = '{VAL_'.($m+1).'}';
                        $final_message .= $message_arr[$m].$suffix;
                    }
                    else{
                        $final_message .= $message_arr[$m];
                    }
                }
            }
            $searchvariables = [];
            if(!empty($sms_records)) {
                for($i=0; $i < count($sms_records); $i++) {
                    $val = $sms_records[$i];
                    $suffix = 'VAL_'.($i+1);
                    $searchvariables[] = array($suffix=>$val);
                }
            }
            $variables = array_flatten($searchvariables);
            $response = preg_replace_callback('/{(.+?)}/xi',function($match)use($variables){
                return !empty($variables[$match[1]]) ? $variables[$match[1]] : $match[0];
            },$final_message);
            $message = urlencode($response);
            $api_params = 'user='.$api_user.'&pass='.$api_pass.'&service='.$api_service.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&te_id='.$api_teid.'&stype=normal&popup=false';
            $url = $api_url.$api_params;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                return false;
            }
            else{
                return true;
            }
            curl_close($ch);
        }
        else{
            return false;
        }
    }
}