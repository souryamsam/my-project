<?php
// print_r($userdata);die;
$user_data = $userdata[0];
if (isset($user_data) && !empty($userdata)) {
   $name = $user_data[0]["E_NAME"];
   $department = $user_data[0]['DEPARTMENT'];
   $contact_no = $user_data[0]['CONTACT_NUMBER'];
   $alt_contact_no = $user_data[0]['ALT_CONTACT_NUMBER'];
   $dob = $user_data[0]['DOB'];
   $created_at = $user_data[0]['CREATE_DATE_TIME'];
   $email = $user_data[0]['EMAIL_ADDRESS'];
   $address = $user_data[0]['PRESENT_ADDRESS'];
   $COUNTRY_CODE = $user_data[0]['COUNTRY_CODE'];
   $pin = $user_data[0]['PIN_CODE'];
   $state_code = $user_data[0]['STATE_CODE'];
   $E_IMAGE = ($user_data[0]['IMAGE'] != "") ? $user_data[0]['IMAGE'] : "default.jpg";
} else {
   $name = "";
   $department = "";
   $contact_no = "";
   $alt_contact_no = "";
   $dob = "";
   $created_at = "";
   $email = "";
   $address = "";
   $COUNTRY_CODE = "IN";
   $pin = "";
   $state_code = "";
   $E_IMAGE = "default.jpg";
}

$country_data = $userdata[1];
$state_data = $userdata[2];
// print_r($state_data);die;
$states = all_states($state_data, $COUNTRY_CODE);
// print_r($states);die;
?>
<div class="row">
   <div class="col-md-12">
      <div class="box box-primary">
         <div class="box-body box-profile">
            <div style="margin: 20px; display: flex">
               <div style="margin-right: 20px">
                  <label for="fileToUpload">
                     <!-- <div class="profile-pic" style="background-image: url('https://randomuser.me/api/portraits/med/men/65.jpg')">
                        <span class=""><i class="fa fa-camera"></i></span>
                        </div> -->
                     <img class="profile-user-img img-responsive img-circle" id="preview"
                        src="<?= file_exists("resources/images/" . $E_IMAGE) ? base_url("resources/images/") . $E_IMAGE : base_url("resources/images/default.jpg") ?>"
                        alt="User profile picture" style=" border:0px;border-radius: 0% !important;">
                  </label>
                  <input type="File" name="profile_image" id="profile_image">
               </div>
               <div class="col-md-10 row">
                  <h3 class=" "><i class="fa fa-tags" style="margin-right:10px;color:#184faf"></i><span
                        class="bg-primary" style="color:white;border-radius:5px;padding:6px"><?= $name ?></span></h3>
                  <span><i class="fa fa-building fa-lg"
                        style="margin-right:20px;margin-top:10px;color:forestgreen"></i><span class="bg-green"
                        style="color:white;border-radius:5px;padding:6px"><?= $department ?></span></span>
               </div>
               <div class="col-md-3 row">
                  <h4 class="h4">
                     <a href="#" id="edit" class="btn btn-primary btn-md">Edit Profile</a>
                  </h4>
                  <span><a class="btn btn-success" data-toggle="modal" data-target="#chgPass">Change Password</a></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row first">
   <div class="col-md-12">
      <div class="box box-primary">
         <div class="box-body box-profile">
            <div class="col-md-5 card-body">
               <div class="card-body">
                  <h3>Email:</h3>
                  <h4 class="text-blue"><?= $email ?></h4>
               </div>
               <div class="card-body">
                  <h3>Contact No:</h3>
                  <h4 class="text-blue"><?= $contact_no ?></h4>
               </div>
               <div class="card-body">
                  <h3>Member Since:</h3>
                  <h4 class="text-blue"><?= date("d-m-Y", strtotime($created_at)); ?></h4>
               </div>
            </div>
            <div class="col-md-7">
               <div class="card-body">
                  <h3>Date of Birth:</h3>
                  <h4 class="text-blue"><?= date("d-m-Y", strtotime($dob)); ?></h4>
               </div>
               <div class="card-body">
                  <h3>Address:</h3>
                  <h4 class="text-blue"><?= $address ?></h4>
               </div>
               <div class="card-body">
                  <h3>Pin Code:</h3>
                  <h4 class="text-blue"><?= $pin ?></h4>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<form method="post" action="<?= base_url('User/updateuser') ?>" autocomplete="off">
   <input type="hidden" name="profilefilename" id="profilefilename" value="<?= $E_IMAGE ?>">
   <div class="row second" style="display: none">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-body box-profile">
               <div class="row">
                  <div class="col-md-5 card-body">
                     <div class="card-body">
                        <h4>Contact No:</h4>
                        <input type="text" class="form-control" name="contact_no" disabled MaxLength="10"
                           onkeypress="return isonlyNumberKey(event)" value="<?= $contact_no ?>" style="width: 80%" />
                     </div>
                     <div class="card-body">
                        <h4>Alt Contact No:</h4>
                        <input type="text" class="form-control number" name="alt_contact_no"
                           placeholder="10 Digit Contact Number" MaxLength="10"
                           onkeypress="return isonlyNumberKey(event)" style="width: 80%"
                           value="<?= $alt_contact_no ?>" />
                     </div>
                     <div class="card-body">
                        <h4>Address:</h4>
                        <input type="text" class="form-control" name="address" required style="width: 80%"
                           value="<?= $address ?>" />
                     </div>
                     <div class="card-body">
                        <h4>Email:</h4>
                        <input type="email" class="form-control" name="email" style="width: 80%" value="<?= $email ?>"
                           placeholder="someone@example.com" />
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="card-body">
                        <h4>Country</h4>
                        <select class="form-control select2" name="country" id="country"
                           onchange="bindStates(event,this.value)" required>
                           <option value="">--select--</option>
                           <?php
                           if (!empty($country_data)) {
                              foreach ($country_data as $country) {
                                 ?>
                                 <option name="country" value="<?= $this->my_encryption->encrypt($country['RECORD_ID']) ?>"
                                    <?= ($country['RECORD_ID'] == $COUNTRY_CODE) ? 'selected' : '' ?>>
                                    <?= $country['RECORD_NAME'] ?>
                                 </option>
                                 <?php
                              }
                           }
                           ?>
                        </select>
                     </div>
                     <div>
                        <h4>State</h4>
                        <select class="form-control select2" name="state" id="state" required>
                           <option value="">Select</option>
                           <?php
                           if (!empty($states)) {
                              foreach ($states as $key => $value) {
                                 ?>
                                 <option name="state" value="<?= $value['STATE_CODE'] ?>"
                                    <?= ($value['STATE_CODE'] == $this->my_encryption->encrypt($state_code)) ? 'selected' : '' ?>>
                                    <?= $value['STATE_NAME']; ?></option>
                                 <?php
                              }
                           }
                           ?>
                        </select>
                     </div>
                     <div class="card-body">
                        <h4>Pin Code:</h4>
                        <input type="text" class="form-control number" name="pincode" placeholder="Pincode"
                           required="required" MaxLength="6" onkeypress="return isonlyNumberKey(event)"
                           value="<?= $pin ?>" />
                     </div>
                     <div class="card-body">
                        <h4>Date of Birth:</h4>
                        <input type="date" class="form-control number" name="dob" id="dob"
                           value="<?= date("Y-m-d", strtotime($dob)); ?>" />
                     </div>
                  </div>
               </div>
               <div class="row card-body">
                  <div class="card-body" style="margin-top: 18px;margin-left:15px">
                     <span class="h4">
                        <button type="submit" class="btn btn-primary" style="width: 80px">Save</button></span>
                     <span>
                        <button type="button" id="cancle_btn" class="btn btn-info"
                           style="width: 100px">Cancel</button></span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>

<div class="modal fade" id="chgPass">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <?= form_open(base_url('User/change_password'), array("id" => "password_form", "autocomplete" => "off")) ?>
         <div class="modal-header">
            <button type="button" class="close text-black" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title text-bold ">Password</h3>
         </div>
         <div class="modal-body">
            <span>Set a strong password to prevent unauthorized access to your account.</span>
            <h5>Old Password:</h5>
            <input type="password" class="form-control" name="old_password" required style="width: 80%" />
            <h5>New Password:</h5>
            <input type="password" class="form-control" name="password" pattern="^\S{6,}$"
               onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.c_password.pattern = this.value;"
               required style="width: 80%" />
            <h5>Retype Password:</h5>
            <input type="password" class="form-control" name="c_password"
               onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');"
               required style="width: 80%" />
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Change Password</button>
         </div>
         <?= form_close() ?>
      </div>
   </div>
</div>

<script>
   $(function () {
      $('#profile_image').hide();

      $('#cancle_btn').on('click', function () {
         $(".first").show();
         $("#pass").show();
         $(".second").hide();
         $('#profile_image').hide();
      })

      $('#edit').click(function (e) {
         e.preventDefault();
         $(".first").hide();
         $("#pass").hide();
         $(".second").show();
         $('#profile_image').show();
      });

      $('#password').click(function (e) {
         e.preventDefault();
         $(".first").hide();
         $(".second").hide();
         $("#pass").show();
      });

      $("#profile_image").on('change', function (e) {
         if ($("#profile_image").val()) {
            e.preventDefault();
            var i = 0;
            var profile_image = $('#profile_image').prop('files')[0];
            var formData = new FormData();
            formData.append('profile_image', profile_image);
            formData.append('csrf_test_name', csrf);
            $.ajax({
               method: 'post',
               url: baseurl + 'User/update_profile_image',
               dataType: 'json',
               data: formData,
               cache: false,
               contentType: false,
               processData: false,
               beforeSend: function () {
                  $(".mainbody").fadeIn("slow");
               },
               success: function (result) {
                  csrf = result.token;
                  if (result.status == '0') {
                     document.getElementById("profilefilename").value = '';
                     document.getElementById("preview").src = baseurl + 'resources/images/default.jpg';
                  }
                  else {
                     if (result.file != "") {
                        document.getElementById("preview").src = baseurl + 'resources/images/' + result.file;
                        document.getElementById("profilefilename").value = result.file;
                     }
                  }
               },
               error: function (xhr) {
                  console.log(xhr);
               },
               complete: function () {
                  $(".mainbody").fadeOut("slow");
               }
            })
         }
      });

      <?php
      if ($this->session->flashdata('update_msg')) {
         $update_msg = $this->session->flashdata('update_msg');
         if ($update_msg["status"] == '1') {
            ?>
            $.toast({
               heading: "Success",
               text: '<?= $update_msg["message"] ?>',
               showHideTransition: "fade",
               position: "top-right",
               icon: "success",
               loader: false
            })
            $("#chgPass").modal("hide");
            <?php
         } else {
            ?>

            $.toast({
               heading: "Warning",
               text: '<?= $update_msg["message"] ?>',
               showHideTransition: "fade",
               position: "top-right",
               icon: "error",
               loader: false
            })
            $("#chgPass").modal("show");
            <?php
         }
      }
      ?>
   })

   function bindStates(e, value) {
      
      $.ajax({
         url: baseurl + "User/get_state_against_country_id",
         type: "POST",
         dataType: "JSON",
         data: {
            "country_id": value,
            "flag_mode": "GET_STATES"
         },
         success: function (result) {
            var str = '<option value="">--select-</option>';
            if (result.length > 0) {
               $.each(result, function (id, obj) {
                  str += '<option value="' + obj.STATE_CODE + '">' + obj.STATE_NAME + '</option>';
               })
            }
            $('#state').html(str);
         }
      });
   }
</script>