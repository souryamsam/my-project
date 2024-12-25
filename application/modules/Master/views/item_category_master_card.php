<?php

if (!empty($single_item_data) && $single_item_data != false) {

    $record_id = $this->my_encryption->encrypt($single_item_data->RECORD_ID);
    $parent_name = $single_item_data->PARENT_RECORD_ID;
    $child_name = $single_item_data->RECORD_NAME;
    $btn = 'Update';
} else {
    $record_id = '';
    $parent_name = '';
    $child_name = '';
    $btn = 'Save';
}
?>

<div class="row">
    <div class="col-md-5">
        <div class="box box-primary">
            <div class="box-header with-border">
                <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-category-master'); ?>"><i
                        class="fa fa-list"></i> View Item
                    Category</a>
            </div>
            <form action="<?= base_url('Master/item_category_master_card_insert'); ?>" method="post">
                <div class="box-body">
                    <input type="hidden" name="edit_id" id="edit_id" value="<?= $record_id ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-label col-md-4">Parent Category <span
                                        class="text-danger">*</span>:</label>
                                <div class="col-md-8">
                                    <select class="form-control input-sm select2" name="pa_category" required>
                                        <option value="">Select</option>
                                        <option value="NA">N/A</option>
                                        <?php
                                        if (!empty($parent_category_data)) {
                                            foreach ($parent_category_data as $prow) {
                                                ?>
                                                <option value="<?= $this->my_encryption->encrypt($prow['RECORD_ID']) ?>"
                                                    <?= $prow['RECORD_ID'] == $parent_name ? 'selected' : '' ?>>
                                                    <?= $prow['RECORD_NAME'] ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php echo form_error('pa_category', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-group row">
                                <label class="form-label col-md-4">Child Category <span
                                        class="text-danger">*</span>:</label>
                                <div class="col-md-8">
                                    <input class="form-control input-sm" name="child_category" required
                                        value="<?php echo set_value('child_category'); ?> <?= $child_name; ?>">
                                    <?php echo form_error('child_category', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
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
            </form>
        </div>
    </div>
</div>

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
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
</script>