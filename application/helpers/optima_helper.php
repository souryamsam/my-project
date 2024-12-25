<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('reqstpage')){
    function reqstpage() {
        defined('BASEPATH') OR exit('No direct script access allowed');
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $page = $_SERVER['PHP_SELF'];
        $page =  $protocol.'://'.$host.''.$page;
        return str_replace('index.php/','',$page);
    }

    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    function removeDocfile($path) {
        $file = FCPATH .$path;
        if (file_exists($file)) {
            if(unlink($file)) {  
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    function array_flatten($array) { 
        if (!is_array($array)) { 
          return FALSE; 
        } 
        $result = array(); 
        foreach ($array as $key => $value) { 
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value)); 
            } 
            else { 
                $result[$key] = $value; 
            } 
        } 
        return $result; 
    }

    function array_values_recursive($ary)  {
        $lst = array();
        foreach( array_keys($ary) as $k ) {
            $v = $ary[$k];
            if (is_scalar($v)) {
                $lst[] = $v;
            } elseif (is_array($v)) {
                $lst = array_merge($lst,array_values_recursive($v));
            }
        }
        return array_values(array_unique($lst)); // used array_value function for rekey
    }

    function single_assoc_array($parentArray) {
        $singleArray  = [];
        foreach ($parentArray as $childArray) 
        { 
            foreach ($childArray as $value) 
            { 
                $singleArray[] = $value; 
            } 
        }
        return $singleArray;
    }

    function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    function createSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    function setLength($x, $length) {
        if(strlen($x)<=$length){
            return $x;
        }
        else{
            $y=substr($x,0,$length) . '...';
            return $y;
        }
    }

    function objectToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    function sort_array_of_array(&$array, $subfield) {
        $sortarray = array();
        foreach ($array as $key => $row) {
            $sortarray[$key] = $row[$subfield];
        }
        array_multisort($sortarray, SORT_ASC, $array);
    }

    function calculateBSA($weight,$height) {
        $bsa_cal = ($weight * $height) / 3600;
        $check_bsa_val = sqrt($bsa_cal);
        $bsa_val = round($check_bsa_val,2);
        return $bsa_val;
    }

    function exists_slug_Opdpatients($slug_val) {
        switch($slug_val){
            case "todays-appointment":
            return true;
            break;
            case "patients-in-queue":
            return true;
            break;
            case "treated-patient-register":
            return true;
            break;
            case "private-opd-register":
            return true;
            break;
            case "second-opinion-register":
            return true;
            break;
            default:
            return false;
        }
    }

    function get_section_title_Opdpatients($slug_val) {
        switch($slug_val){
            case "todays-appointment":
            return "Today's Appointments";
            break;
            case "patients-in-queue":
            return "Patients In Queue";
            break;
            case "treated-patient-register":
            return "Treated Patients Register";
            break;
            case "advised-admission-register":
            return "Advised Admission Register";
            break;
            case "referred-patient-register":
            return "Referred Patient Register";
            break;
            case "private-opd-register":
            return "Private OPD Register";
            break;
            case "second-opinion-register":
            return "Second Opinion Register";
            break;
            case "tumor-board-register":
            return "Tumor Board Register";
            break;
            default:
            return "";
        }
    }

    function all_states($state_data,$country_id) {
        $final_states = [];
        $ci =&get_instance();
        foreach($state_data as $data) {
            if($data["COUNTRY_CODE"] == $country_id) {
                $final_states[] = array(
                    "STATE_NAME"=>$data["STATE_NAME"],
                    "STATE_CODE"=>$ci->my_encryption->encrypt($data["STATE_CODE"])
                );                
            }
        }
        return $final_states;
    }

    function removeSpclchars($str){
        $res = str_replace( array( '\'', '"',
      ',' , ';', '<', '>','=' ), '', $str);
      return $res;
    }

    function filterPatenttype($encounter_type) {
        switch($encounter_type) {
            CASE "OUTPATIENT";
            return "Outdoor";
            break;
            CASE "INTPATIENT";
            return "Indoor";
            break;
            DEFAULT:
            return "Indoor";
        }
    }

    function formatdate($date){
        if($date != "") {
            $from_date = explode('-',$date);
            $set_date = new DateTime();
            $set_date->setDate($from_date[2], $from_date[1], $from_date[0]);
            return $set_date->format('Y-m-d');
        }
        else{
            return '';
        }
    }

    function gettestGroupname($group_name) {
        switch($group_name){
            case "patho":
            return 'Pathology';
            break;
            case "lab":
            return 'Laboratory';
            break;
            case "cardio":
            return 'Cardiology';
            break;
            case "radio":
            return 'Radiology';
            break;
            default:
            return false;
        }
    }

    function getCharlseagepoint($age) {
        $age = array_filter(preg_split("/\D+/", $age));
        $age = reset($age);
        $value = 0;
        if ($age < 50) {
            $value = 1;
        } else if ($age >= 50 && $age <= 60) {
            $value = 2;
        } else if ($age >= 60 && $age <= 70) {
            $value = 3;
        } else if ($age >= 70) {
            $value = 4;
        } else if ($age > 80) {
            $value = 5;
        } else {
            $value = 6;
        }
        return $value;
    }

    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
        foreach($period as $date) { 
            $array[] = $date->format($format); 
        }
    
        return $array;
    }

    function save_patient_barcode($uhid_prefix,$uhid_id){
        $ci =&get_instance();
        if (!is_dir('resources/EMR/'.$uhid_prefix)) {
            mkdir('resources/EMR/'.$uhid_prefix, 0777, TRUE);        
        }
        if(is_dir('resources/EMR/'.$uhid_prefix)) {
            $ci->load->library("Barcode_jpg");
            $file_path = './resources/EMR/'.$uhid_prefix.'/';
            $file = FCPATH .$file_path;
            if (file_exists($file)) {
                file_put_contents($file_path.$uhid_id.'.jpg', $ci->barcode_jpg->getBarcode($uhid_id, $ci->barcode_jpg::TYPE_CODE_128));
            }
        }
    }

    function slug_to_page($slug) {
        if($slug != "") {
            $slug_arr = explode('-',$slug);
            $page_name = '';
            if(!empty($slug_arr)) {
                for($i=0; $i<count($slug_arr); $i++) {
                    if($i == 0) {
                        switch($slug_arr[$i]) {
                            case 'opd';
                                $page_name .= strtoupper($slug_arr[$i]).'&nbsp';
                            break;
                            case 'ot';
                                $page_name .= strtoupper($slug_arr[$i]).'&nbsp';
                            break;
                            default:
                                $page_name .= ucfirst(strtolower($slug_arr[$i])).'&nbsp';
                            break;
                        }
                    }
                    else{
                        $page_name .= ucfirst(strtolower($slug_arr[$i])).'&nbsp';
                    }
                }
            }
            return $page_name;
        }
        else{
            return false;
        }
    }

    function geterate_uniqid() {
        return random_int(100, 100000);
    }
}