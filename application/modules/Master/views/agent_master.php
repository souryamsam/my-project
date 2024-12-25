<?php
if (!empty($single_agent_data) && $single_agent_data != false) {
    $agent_id = $this->my_encryption->encrypt($single_agent_data->RECORD_ID);
    $agent_name = $single_agent_data->RECORD_NAME;
    $agent_phone_number = $single_agent_data->DESC_1;
    $agent_email = $single_agent_data->DESC_2;
    $agent_address = $single_agent_data->DESC_3;
    $agent_document = $single_agent_data->DESC_4;
    $agent_id_no = $single_agent_data->DESC_5;
    $agent_id_photo = $single_agent_data->DESC_6;
    $btn = 'Update';
} else {
    $agent_id = '';
    $agent_name = '';
    $agent_phone_number = '';
    $agent_email = '';
    $agent_address = '';
    $agent_document = '';
    $agent_id_no = '';
    $agent_id_photo = '';
    $btn = 'Save';
}
?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url("view-agent"); ?>"><i
                            class="fa fa-list"></i> View
                        Agent</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?= form_open(base_url('Master/agent_master_insert'), ['enctype' => 'multipart/form-data']); ?>
                        <input type="hidden" name="agent_id" value="<?= $agent_id ?>">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Agent Name <span class="text-danger">*</span></label>
                                <input type="text" value="<?= set_value('agent_name'); ?><?= $agent_name ?>"
                                    name="agent_name" class="form-control input-sm" autocomplete="off" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" required>
                            </div>
                            <?= form_error('agent_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" maxlength="10" minlength="10"
                                    value="<?= set_value('mobile_number'); ?><?= $agent_phone_number ?>"
                                    name="mobile_number" class="form-control number" autocomplete="off" required>
                            </div>
                            <?= form_error('mobile_number', '<div class="text-danger text-capitalize">', '</div>'); ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Email Id</label>
                                <input type="email" value="<?= set_value('email'); ?><?= $agent_email ?>" name="email"
                                    class="form-control input-sm" autocomplete="off"
                                    oninput="enforceLowercaseEmail(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="mb-1">Address</label>
                                <input type="text" value="<?= set_value('address'); ?><?= $agent_address ?>"
                                    name="address" class="form-control input-sm" id="item-details">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Document Type<span class="text-danger">*</span></label>
                                <select class="form-control input-sm" name="d_type" id="d_type">
                                    <option>Select</option>
                                    <?php
                                    if (!empty($agent_master_pageload_data)) {
                                        foreach ($agent_master_pageload_data as $agent_data) {
                                            ?>
                                            <option value="<?= $this->my_encryption->encrypt($agent_data['RECORD_ID']) ?>"
                                                <?= (set_select('d_type', $this->my_encryption->encrypt($agent_data['RECORD_ID']))) ? 'selected' : '' ?>
                                                <?= $agent_data['RECORD_ID'] == $agent_document ? 'selected' : '' ?>>
                                                <?= $agent_data['DESC_1'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?= form_error('d_type', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">ID No.<span class="text-danger">*</span></label>
                                <input type="text" 
                                    value="<?= set_value('d_no'); ?><?= $agent_id_no ?>" name="d_no" id="d_no"
                                    class="form-control input-sm" required>
                            </div>
                            <?= form_error('d_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                        </div>
                        <div class="col-md-4">
                            <?php if (empty($agent_id_photo)) { ?>
                                <div class="form-group">
                                    <label class="mb-1">Upload Document<span class="text-danger">*</span></label>
                                    <input type="file" id="file_upload" class="form-control input-sm" multiple=""
                                        name="upload_photo[]" value="<?= set_value('upload_photo[]'); ?>"
                                        accept="png/jpg/jpeg/bmp" required>
                                </div>
                            <?php } else {
                                $agent_file_names_array = explode(',', $agent_id_photo);
                                ?>
                                <div class="form-group">
                                    <?php foreach ($agent_file_names_array as $file_name) { ?>
                                        <a href="<?= base_url('resources/uploads/agent_image/' . $file_name) ?>"
                                            data-lightbox="agent-images" data-title="<?= $file_name ?>">
                                            <img class="viewimg"
                                                src="<?= base_url('resources/uploads/agent_image/' . $file_name) ?>"
                                                alt="<?= $file_name ?>">
                                        </a>
                                        <input type="hidden" name="existing_file_paths[]" value="<?= $file_name; ?>" />
                                    <?php } ?>
                                    <input type="file" id="file_upload" class="form-control input-sm" multiple=""
                                        name="upload_photo[]" accept="png/jpg/jpeg/bmp">
                                </div>
                            <?php } ?>
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
    function enforceLowercaseEmail(event) {
        var input = event.target;
        input.value = input.value.toLowerCase();
    }
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
        $('#d_type').on('change',function () {
            var selectedText = $.trim($("#d_type option:selected").text());
            if (selectedText == 'AADHAAR CARD') {
                $('#d_no').attr({minlength: 12,maxlength: 12});
            }else if (selectedText == 'PAN CARD') {
                $('#d_no').attr({minlength: 10,maxlength: 10});
            }else if (selectedText == 'DRIVING LICENCE') {
                $('#d_no').attr({minlength: 15,maxlength: 15});
            }else{ 
                $('#d_no').attr({minlength: 10,maxlength: 20});
            }
        });
    })
</script>