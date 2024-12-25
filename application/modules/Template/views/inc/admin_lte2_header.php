<?php
if ($this->session->userdata("user_data")) {
  $users = $this->session->userdata("user_data");
  if (!empty($users)) {
    $E_NAME = $users["E_NAME"];
    $E_IMAGE = ($users["E_IMAGE"] != "") ? $users["E_IMAGE"] : "logopic.png";
    $DEPARTMENT = $users['DEPARTMENT'];
    /* $DEPARTMENT_CODE = $users['DEPARTMENT_CODE'] ;
      $CONTACT_NUMBER = $users['CONTACT_NUMBER'];
      $DOB =  $users['DOB'] ;
      $CREATED_DTAE_TIME = $users['CREATE_DATE_TIME'];
      $EMAIL_ADDRESS = $users['EMAIL_ADDRESS'];
      $ADDRESS = $users['ADDRESS'];
      $PIN_CODE = $users['PIN_CODE']; */
  } else {
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
} else {
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
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= config_item("project_title") ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?= base_url('resources/images/optima-icon.png') ?>" />
  <?= link_tag("resources/css/bootstrap.min.css") ?>
  <?= link_tag("resources/css/font-awesome.min.css") ?>
  <?= link_tag("resources/css/cludo.css") ?>
  <?= link_tag("resources/css/skin-blue-light.css") ?>
  <?= link_tag("resources/css/select2.css") ?>
  <?= link_tag("resources/css/dataTables.bootstrap.min.css") ?>
  <?= link_tag("resources/css/easy-autocomplete.css") ?>
  <?= link_tag("resources/css/easy-autocomplete.themes.css") ?>
  <?= link_tag("resources/css/jquery-ui.min.css") ?>
  <?= link_tag("resources/css/custom.css") ?>
  <?= link_tag('resources/toastr/jquery.toast.css') ?>
  <?= link_tag("resources/css/sweetalert.min.css") ?>
  <?= link_tag("resources/css/lightbox.css") ?>
  <link rel="icon" type="image/x-icon" href="<?= base_url("resources/images/optima-icon.png") ?>" />

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
  <!-- <script src="https://kit.fontawesome.com/cbcde1e0e6.js"></script> -->
  <script src="<?= base_url("resources/js/jquery.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/jquery-ui.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/bootstrap.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/cludo.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/number_validation.js") ?>"></script>
  <script src="<?= base_url("resources/js/jquery.slimscroll.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/fastclick.js") ?>"></script>
  <script src="<?= base_url("resources/js/select2.js") ?>"></script>
  <script src="<?= base_url("resources/js/jquery.easy-autocomplete.js") ?>"></script>
  <script src="<?= base_url("resources/js/sweetalert.min.js") ?>"></script>
  <script src="<?= base_url("resources/customJS/SwalMessages.js") ?>"></script>
  <script src="<?= base_url('resources/toastr/jquery.toast.js') ?>"></script>
  <script src="<?= base_url("resources/js/jquery.dataTables.min.js") ?>"></script>
  <script src="<?= base_url("resources/js/dataTables.bootstrap.min.js") ?>"></script>
  <script src="<?= base_url('resources/js/datatable-resources/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= base_url('resources/js/datatable-resources/buttons.html5.min.js') ?>"></script>
  <script src="<?= base_url('resources/js/datatable-resources/buttons.print.min.js') ?>"></script>
  <script src="<?= base_url('resources/js/datatable-resources/jszip.min.js') ?>"></script>
  <script src="<?= base_url('resources/js/datatable-resources/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('resources/js/datatable-resources/vfs_fonts.js') ?>"></script>
  <script src="<?= base_url('resources/js/lightbox.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('resources/customJS/ckeditor.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('resources/validation/js/jquery.validate.js') ?>"></script>

  <script>
    const baseurl = '<?= base_url() ?>';
    let csrf = '<?= $this->security->get_csrf_hash() ?>';
    $.ajaxSetup({
      method: "post",
      data: {
        '<?php echo $this->security->get_csrf_token_name(); ?>': csrf
      }
    });

    $(function() {
      $(".select2").select2();
      $('.datepicker').datepicker({
        autoclose: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'dd-mm-yy'
      }).attr("readonly", "readonly");
    });
  </script>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
<div id="loader" class="loader"></div>
  <div class="mainbody" style="display: none;">
    <div class="bt-spinner"></div>
  </div>
  <div class="wrapper">
    <?php
    if ($E_NAME != "") {
    ?>
      <header class="main-header">
        <a href="<?= base_url($this->session->userdata("fav_Page")) ?>" class="logo">
          <span class="logo-lg"><b><?= config_item("project_name") ?></b> </span>
          <span class="logo-mini">
            <img src="<?= base_url("resources/images/optima-icon.png") ?>">
          </span>
        </a>
        <nav class="navbar navbar-static-top">
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= file_exists("resources/images/" . $E_IMAGE) ? base_url("resources/images/") . $E_IMAGE : base_url("resources/images/logopic.png") ?>" id="img_rightAnch" class="user-image" alt="User Image" />
                  <span id="spnName" class="hidden-xs"><?= $E_NAME ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <img src="<?= file_exists("resources/images/" . $E_IMAGE) ? base_url("resources/images/") . $E_IMAGE : base_url("resources/images/logopic.png") ?>" id="img_rightP" class="img-circle" alt="User Image" />
                    <p>
                      <span id="spnName_inHeader"><?= $E_NAME ?></span>
                      <small id="spnDept"><?= substr(trim($DEPARTMENT), 0, -1) ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?= base_url("profile") ?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a class="btn btn-default btn-flat" href="<?= base_url('logout') ?>">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <li>
                  <a href="<?=base_url("settings")?>"><i class="fa fa-gears"></i></a>
                </li>
              <!-- <li>
                    <a href="#"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
          </div>
        </nav>
      </header>
    <?php
    }
    ?>
    <!-- hidden form start -->
    <form id="custom_form" method="post">
      <input type="hidden" name="custom_id" id="custom_id">
      <input type="hidden" name="mode" id="mode">
      <input type="hidden" name="ext_flag" id="ext_flag">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    </form>
    <!-- hidden form end -->