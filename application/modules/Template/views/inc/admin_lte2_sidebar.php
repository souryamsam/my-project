<?php
if($this->session->userdata("user_data")){
   $users = $this->session->userdata("user_data");
   if(!empty($users)) {
      $E_NAME = $users["E_NAME"];
      $E_IMAGE = ($users["E_IMAGE"] != "")?$users["E_IMAGE"]:"logopic.png";
      $DEPARTMENT = $users['DEPARTMENT'] ;
      /* $DEPARTMENT_CODE = $users['DEPARTMENT_CODE'] ;
      $CONTACT_NUMBER = $users['CONTACT_NUMBER'];
      $DOB =  $users['DOB'] ;
      $CREATED_DTAE_TIME = $users['CREATE_DATE_TIME'];
      $EMAIL_ADDRESS = $users['EMAIL_ADDRESS'];
      $ADDRESS = $users['ADDRESS'];
      $PIN_CODE = $users['PIN_CODE']; */
   }
   else{
      $E_NAME = "";
      $E_IMAGE = "logopic.png";
      $DEPARTMENT = "";
      /* $DEPARTMENT_CODE = "";
      $CONTACT_NUMBER = "";
      $DOB = "";
      $CREATED_DTAE_TIME = "";
      $EMAIL_ADDRESS = "";
      $ADDRESS = "";
      $PIN_CODE = ""; */
   }
}
else{
   $E_NAME = "";
   $E_IMAGE = "logopic.png";
   $DEPARTMENT = "";
   /* $DEPARTMENT_CODE = "";
   $CONTACT_NUMBER = "";
   $DOB = "";
   $CREATED_DTAE_TIME = "";
   $EMAIL_ADDRESS = "";
   $ADDRESS = "";
   $PIN_CODE = ""; */
}
if($E_NAME != "") {
?>
<aside class="main-sidebar">
   <section class="sidebar">
      <div class="user-panel">
         <div class="pull-left image">
            <img src="<?=file_exists("resources/images/".$E_IMAGE)?base_url("resources/images/").$E_IMAGE:base_url("resources/images/logopic.png")?>" id="img_leftUserPanel" class="img-circle" alt="User Image" />
         </div>
         <div class="pull-left info">
            <p>Welcome !</p>
            <strong><p id="pUserName"></p><?=$E_NAME?></strong>
            <a href="#" style="display: none;"><i class="fa fa-circle text-success"></i><span id="spnDesig">Chief Accounts Officer</span></a>
         </div>
      </div>
     
      <ul class="sidebar-menu" data-widget="tree">
         <li >
            <h3 style="border-top:1px solid #d9d9d9 !important; margin:0 14px 0 14px;"></h3>
         </li>
         <!-- sidebar menus -->
         <?=$this->my_encryption->decrypt($this->menu->menu_bind("LEFT"));?>
         <!-- end -->
      </ul>
   </section>
</aside>
<?php
}
?>