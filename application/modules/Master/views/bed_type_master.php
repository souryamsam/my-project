<?php
if (!empty($single_bed_data) && $single_bed_data != false) {
    $bed_id = $this->my_encryption->encrypt($single_bed_data->RECORD_ID);
    $bed_name = $single_bed_data->RECORD_NAME;
    $btn = 'Update';
} else {
    $bed_id = '';
    $bed_name = '';
    $btn = 'Save';
}
?>
<section class="content">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-bed-type'); ?>"><i
                            class="fa fa-list"></i> View Bed Type</a>
                </div>
                <form action="<?= base_url('Master/bed_type_master_insert'); ?>" method="post">
                    <div class="box-body">
                        <input type="hidden" name="bed_id" id="bed_id" value="<?= $bed_id ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="form-label col-md-4">Bed Type :</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control input-sm" name="bed_type"
                                            value="<?= $bed_name ?><?php echo set_value('bed_type'); ?>">
                                    </div>
                                    <?php echo form_error('bed_type', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="float-end">
                            <button type="submit" class="btn btn-success btn-sm float-right"><i
                                    class="fa fa-save"></i>&nbsp;<?= $btn ?></button>
                        </div>

                </form>
            </div>
        </div>
    </div>
</section>
<script>
    <?php
    if ($this->session->flashdata('msg')) {
        $msg = $this->session->flashdata('msg');
        if ($msg["status"] == '1') {
            ?>
            $.toast({
                heading: "Success!",
                text: "<?= $msg["message"] ?>",
                showHideTransition: "fade",
                position: "top-right",
                icon: "success",
                loader: true,
                timeout: 30000
            }, function () {
                return true;
            });
            <?php
        } else {
            ?>
            $.toast({
                heading: "Warning",
                text: "<?= $msg["message"] ?>",
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: true,
                timeout: 30000
            })

            <?php
        }
        unset($_SESSION["msg"]);
    }
    ?>
</script>