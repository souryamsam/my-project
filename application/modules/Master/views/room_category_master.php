<?php
if (!empty($single_room_data) && $single_room_data != false) {
    $room_id = $this->my_encryption->encrypt($single_room_data->RECORD_ID);
    $room_name = $single_room_data->RECORD_NAME;
    $btn = 'Update';
} else {
    $room_id = '';
    $room_name = '';
    $btn = 'Save';
}
?>
<section class="content">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-room-category'); ?>"><i
                            class="fa fa-list"></i> View Room
                        Category</a>
                </div>
                <?= form_open('Master/room_category_master_insert'); ?>
                <div class="box-body">
                    <input type="hidden" name="room_id" value="<?= $room_id ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-label col-md-4">Room Category :</label>
                                <div class="col-md-8">
                                    <input class="form-control input-sm" name="room_cate"
                                        value="<?= $room_name ?><?= set_value('room_cate'); ?>">
                                </div>
                                <?= form_error('room_cate', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="float-end">
                        <button type="submit" class="btn btn-success btn-sm float-right"><i
                                class="fa fa-save"></i>&nbsp;<?= $btn ?></button>
                    </div>

                </div>
                <?= form_close(); ?>
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
}, function() {
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