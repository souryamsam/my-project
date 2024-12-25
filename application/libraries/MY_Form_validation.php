<?php
class MY_Form_validation extends CI_Form_validation
{

   function __construct($rules = array())
   {
      parent::__construct($rules);
      $this->ci = &get_instance();
   }



   function checkmaxdate($collection_date)
   {
      $collection_date = new DateTime($collection_date);
      $current_date = new DateTime(date('Y-m-d'));
      $todate = date('d-m-Y');
      if ($collection_date > $current_date) {
         $this->ci->form_validation->set_message('checkmaxdate', "Collection date colud not be greater than date " . $todate . ".");
         return FALSE;
      } else {
         return TRUE;
      }
   }
   public function validate_age($dob)
   {
      $current_date = date("d-m-Y");
      $birthday = date('d-m-Y', strtotime($dob));
      $date1 = new DateTime($birthday);
      $date2 = new DateTime($current_date);

      $interval = $date1->diff($date2);
      $age = $interval->y;

      if ($age >= 18) {
         return true;
      } else {
         $this->ci->form_validation->set_message('validate_age', 'Age must be greater than 18.');
         return false;
      }
   }


   function duplicate_mobile_no()
   {
      try {
         $procedure = "EXEC CHECK_DUPLICATE_FOR_GUEST @CHECK_TYPE  = 'CONTACT',@CHECK_VALUE ='" . $_POST["mobile"] . "' ";
         $query = sqlsrv_query($this->ci->db->conn_id, $procedure);
         $data = [];
         do {
            $array = [];
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
               $array[] = $row;
            }
            $data[] = $array;
         } while (sqlsrv_next_result($query));
         $data = array_flatten(array_values($data));
         if ($data["STATUS"] == "DUPLICATE") {
            $this->ci->form_validation->set_message('duplicate_mobile_no', 'This Mobile Number is already Registered.');
            return false;
         } else {
            return true;
         }
      } catch (Exception $e) {
         exit('Error message: ' . $e->getMessage());
      }
   }
}
?>