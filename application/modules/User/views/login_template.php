<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?= config_item("project_title") ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <?= link_tag("resources/css/bootstrap.min.css") ?>
  <?= link_tag("resources/css/font-awesome.min.css") ?>
  <?= link_tag("resources/css/cludo.css") ?>
  <?= link_tag("resources/css/skin-blue-light.css") ?>
  <?= link_tag("resources/css/jquery-ui.min.css") ?>
  <?= link_tag("resources/toastr/jquery.toast.css") ?>
  <?= link_tag("resources/css/userfavourite.css") ?>
  <link rel="icon" type="image/x-icon" href="<?= base_url("resources/images/favicon.ico") ?>" />
  <script src="<?= base_url("resources/js/jquery.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/jquery-ui.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/bootstrap.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/cludo.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/number_validation.js") ?>"></script>
  <script src="<?= base_url("resources/toastr/jquery.toast.js") ?>"></script>
</head>
<?php
if($this->session->flashdata('login_msg')) {
  $output = $this->session->flashdata('login_msg');
  if(!empty($output)) {
    $username = $output["data"]["username"];
    $password = $this->my_encryption->decrypt($output["data"]["password"]);
  }
  else{
    $username = set_value("userid");
    $password = set_value("password");
  }
}
else{
  $username = set_value("userid");
  $password = set_value("password");
}
?>
<body class="hold-transition" style="background-image: url(<?= base_url("resources/images/login-background.jpg") ?>); background-size: cover; height: auto; min-height: 100%;">
  <div class="login-box">
    <div class="login-logo">
      <span style="color: #af671b;"><b>HOTEL</b> ERP</span>
    </div>
    <?= form_open(base_url('User/user_logging_in'), array("class" => "login_form", "id" => "login_form", "autocomplete" => "off")) ?>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div action="#" method="post">
        <div class="form-group has-feedback">
          <input type="text" autocomplete="off" maxlength="10" id="userid" name="userid" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return isonlyNumberKey(event)" class="form-control number" value="<?=$username?>" placeholder="User Name" required/>
          <span class="fa fa-user-secret form-control-feedback"></span>
          <small class="text-danger" id="userid_err"><?= form_error("userid") ?></small>
        </div>
        <div class="form-group has-feedback">
          <input type="password" autocomplete="off" id="password" name="password" class="form-control" value="<?=$password?>" placeholder="Password" required/>
          <span class="fa fa-lock form-control-feedback"></span>
          <small class="text-danger" id="userid_err"><?= form_error("password") ?></small>
        </div>
        <div class="row">
          <div class="col-md-8">
            <!-- <a href="javascript:void(0)">Forgot Password ?</a> -->
            <a href="javascript:void(0)">&nbsp;</a>
          </div>
          <div class="col-xs-4">
            <input type="submit" name="btnLogin" value="Sign In" id="btnLogin" class="btn btn-signin btn-block btn-flat" />
          </div>
        </div>
      </div>
      <br />
      <label id="lblCompanyName" class="text-red text-uppercase">Parbon Erp</label><br />
      <label id="lblLicenceNo" class="text-info text-uppercase">License No - 123456789012345669</label><br />
      <label class="text-light-blue text-uppercase">Version - 3.4</label>
    </div>
    <?= form_close() ?>
  </div>
  <?= $this->load->view('User/modal/user_favorite-template'); ?>
</body>
<script>
  $(function() {
    <?php
    if ($this->session->flashdata('login_msg')) {
      $msg = $this->session->flashdata('login_msg');
      if ($msg["status"] == '1') {
    ?>
        $.toast({
          heading: "Success",
          text: '<?= $msg["message"] ?>',
          showHideTransition: "fade",
          position: "top-right",
          icon: "success",
          loader: false
        })
      <?php
      } else {
      ?>
        $.toast({
          heading: "Warning",
          text: '<?= $msg["message"] ?>',
          showHideTransition: "fade",
          position: "top-right",
          icon: "error",
          loader: false
        })
    <?php
      }
    }
    ?>
    setTimeout(function(){
      var fieldInput = $('#userid');
      var fldLength= fieldInput.val().length;
      fieldInput.focus();
      fieldInput[0].setSelectionRange(fldLength, fldLength);
    },300)
  })
</script>

</html>