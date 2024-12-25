<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="<?= $icon ?>" style="<?= $icon_color ?>" aria-hidden="true"></i>
      <?= ($page_header_name != "") ? $page_header_name : $page_title ?>
      
      <?php
      if(str_contains($this->uri->segment(1), 'chemotherapy')) {
        ?>
        <a href="javascript:void(0)" onclick="open_day_care_modal(event)" class="btn btn-sm btn-info" >
          <i class="fa fa-bed"></i>&nbsp;Day Care Bed Status
        </a>
        <?php
      }
      ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= ($page_header_name != "") ? $page_header_name : $page_title ?></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?= $this->load->view("patient_header_template") ?>
    <?= $this->load->view($content_view) ?>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->