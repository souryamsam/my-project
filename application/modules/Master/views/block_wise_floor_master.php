<?php
if (!empty($single_block_data) && $single_block_data != false) {
    $block_id = $this->my_encryption->encrypt($single_block_data->RECORD_ID);
    $block_name = $single_block_data->PARENT_RECORD_ID;
    $floor_name = $single_block_data->RECORD_NAME;
    $btn = 'Update';
} else {
    $block_id = '';
    $block_name = '';
    $floor_name = '';
    $btn = 'Save';
}

?>

    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-block-wise-floor'); ?>"><i
                            class="fa fa-list"></i> View Block Wise Floor</a>
                </div>
                <form action="<?= base_url('Master/block_wise_floor_master_insert'); ?>" class="form-horizontal"
                    method="post">
                    <div class="box-body">
                        <input type="hidden" name="block_id" id="block_id" value="<?= $block_id ?>">
                        <div class="form-group">
                            <label class="form-label col-md-3">Block Name :</label>
                            <div class="col-md-9">
                                <select class="form-control input-sm select2" id="block_name_id" name="block_name"
                                    required>
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($block_name_data)) {
                                        foreach ($block_name_data as $brow) {
                                            ?>
                                            <option value="<?= $this->my_encryption->encrypt($brow['RECORD_ID']) ?>"
                                                <?= $brow['RECORD_ID'] == $block_name ? 'selected' : '' ?>
                                                <?= (set_select('block_name', $this->my_encryption->encrypt($brow['RECORD_ID']))) ? 'selected' : '' ?>>
                                                <?= $brow['RECORD_NAME'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?= form_error('block_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label col-md-3">Floor Name :</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control input-sm" placeholder="Enter floor name"
                                    aria-label="Enter floor name" aria-describedby="basic-addon2" id="floor_name_id"
                                    name="floor_name" value="<?= $floor_name ?><?= set_value('floor_name'); ?>"
                                    required>
                                <?= form_error('floor_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="float-end">
                            <button type="submit" id="save_button" class="btn btn-success btn-sm float-right"><i
                                    class="fa fa-save"></i>&nbsp;<?= $btn ?></button>
                        </div>
                </form>
            </div>
        </div>
    </div>

<script>
    $('#floor_name_id').on('keyup', function () {
        var block_name = $('#block_name_id').val();
        var floor_name = $(this).val();
        if (block_name && floor_name) {
            $.ajax({
                url: baseurl + 'Master/floor_name_duplicate_check',
                type: 'POST',
                dataType: 'json',
                data: {
                    block_name: block_name,
                    floor_name: floor_name,
                },
                success: function (response) {
                    if (response.status === '1') {
                        $.toast({
                            heading: "Warning",
                            text: response.message,
                            showHideTransition: "fade",
                            position: "top-right",
                            icon: "error",
                            loader: true,
                            timeout: 3000
                        });
                        $('#floor_name_id').val('');
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
    });
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
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
</script>