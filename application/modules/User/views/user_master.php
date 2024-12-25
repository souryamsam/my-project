<?php
if (!empty($user_single_data)) {
    $user_id = $this->my_encryption->encrypt($user_single_data['USER_CODE']);
    $user_title = $user_single_data['SALUTATION'];
    $user_name = $user_single_data['E_NAME'];
    $user_dep = $user_single_data['DEPARTMENT'];
    $user_designation = $user_single_data['DESIGNATION'];
    $user_contact_no = $user_single_data['CONTACT_NUMBER'];
    $user_alt_contact_no = $user_single_data['ALT_CONTACT_NUMBER'];
    $user_dob = date('d-m-Y', strtotime($user_single_data['DOB']));
    $user_gender = $user_single_data['GENDER'];
    $user_email = $user_single_data['EMAIL_ADDRESS'];
    $user_country = $user_single_data['COUNTRY_CODE'];
    $user_state = $this->my_encryption->encrypt($user_single_data['STATE_CODE']);
    $user_pincode = $user_single_data['PIN_CODE'];
    $user_photo = $user_single_data['AVATAR'];
    $user_address = $user_single_data['PRESENT_ADDRESS'];
    $user_role_arr = explode(', ', $user_single_data['USER_GROUP_ID']);
    $encrypted_user_role = array_map(function ($id) {
        return $this->my_encryption->encrypt($id);
    }, $user_role_arr);
    $btn = 'Update';
} else {
    $user_id = '';
    $user_title = set_value('user_title');
    $user_name = set_value('user_name');
    $user_dep = '';
    $user_designation = '';
    $user_contact_no = set_value('user_contact_no');
    $user_alt_contact_no = set_value('user_alt_contact_no');
    $user_dob = set_value('user_dob');
    $user_gender = set_value('user_gender');
    $user_email = set_value('user_email');
    $user_country = set_value('user_country');
    $user_state = set_value('user_state');
    $user_pincode = set_value('user_pincode');
    $user_photo = 'no-image.png';
    $user_address = set_value("user_address");
    $user_role_arr = [];
    $encrypted_user_role = [];
    $btn = 'Save';
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border ">
                <a class="btn btn-primary btn-sm float-right" href="<?= base_url('user-list'); ?>"><i class="fa fa-list"></i>&nbsp; View User</a>
            </div>
            <div class="box-body">
                <?= form_open(base_url('User/user_master_insert'), ['enctype' => 'multipart/form-data']); ?>
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <div class="form-horizontal">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Name<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control input-sm" name="user_title" required>
                                                <option value="">Select</option>
                                                <option value="Mr." <?= ($user_title == 'Mr.') ? 'selected' : '' ?>>Mr.
                                                </option>
                                                <option value="Ms." <?= ($user_title == 'Ms.') ? 'selected' : '' ?>>Ms.
                                                </option>
                                                <option value="Mrs." <?= ($user_title == 'Mrs.') ? 'selected' : '' ?>>
                                                    Mrs.</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control input-sm" name="user_name"
                                                value="<?= $user_name?>" required>
                                            <?=form_error('user_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Department<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm select2" name="user_dep" required>
                                        <option value="">Select</option>
                                        <?php
                                            if (!empty($department_data)) {
                                                foreach ($department_data as $srow) {
                                                    ?>
                                        <option value="<?= $this->my_encryption->encrypt($srow['RECORD_ID']) ?>"
                                            <?= (set_select('user_dep', $this->my_encryption->encrypt($srow['RECORD_ID']))) ? 'selected' : '' ?>
                                            <?= $srow['RECORD_ID'] == $user_dep ? 'selected' : '' ?>>
                                            <?= $srow['RECORD_NAME'] ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                    <?= form_error('user_dep', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Designation<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm select2" name="user_designation" required>
                                        <option value="">Select</option>
                                        <?php
                                            if (!empty($designation_data)) {
                                                foreach ($designation_data as $drow) {
                                                    ?>
                                        <option value="<?= $this->my_encryption->encrypt($drow['RECORD_ID']) ?>"
                                            <?= (set_select('user_designation', $this->my_encryption->encrypt($drow['RECORD_ID']))) ? 'selected' : '' ?>
                                            <?= $drow['RECORD_ID'] == $user_designation ? 'selected' : '' ?>>
                                            <?= $drow['RECORD_NAME'] ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                    <?= form_error('user_designation', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Contact No.<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="text" minlength="10" maxlength="10"
                                                class="form-control input-sm number" name="user_contact_no"
                                                value="<?= $user_contact_no;?>" id="contact_no"
                                                onkeyup="duplicate_checking(event, this, 'MOBILE')" required>
                                            <?= form_error('user_contact_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                            <div class="text-danger text-capitalize" id="duplicateMessage"> </div>
                                        </div>
                                        <label class="col-sm-3 control-label">Alt. ContactNo.</label>
                                        <div class="col-sm-4">
                                            <input type="text" minlength="10" maxlength="10"
                                                class="form-control input-sm number" name="user_alt_contact_no"
                                                value="<?= $user_alt_contact_no?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">DOB<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="text" placeholder="DD/MM/YYYY"
                                                class="form-control input-sm datepicker " name="user_dob"
                                                value="<?= $user_dob?>" required>
                                            <?= form_error('user_dob', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                        <label for="" class="col-sm-3 control-label">Gender<span
                                                class="required_span">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control input-sm" name="user_gender" required>
                                                <option value="">Select</option>
                                                <option value="MALE" <?= ($user_gender == 'MALE') ? 'selected' : '' ?>>
                                                    MALE</option>
                                                <option value="FEMALE"
                                                    <?= ($user_gender == 'FEMALE') ? 'selected' : '' ?>>FEMALE</option>
                                                <option value="TRANSGENDER"
                                                    <?= ($user_gender == 'TRANSGENDER') ? 'selected' : '' ?>>TRANSGENDER
                                                </option>
                                            </select>
                                            <?= form_error('user_gender', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm" name="user_email" id="email_id"
                                        onkeyup="duplicate_checking(event, this, 'EMAIL')"
                                        oninput="enforceLowercaseEmail(event)" value="<?=$user_email?>">
                                    <?= form_error('user_email', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                    <div class="text-danger text-capitalize" id="duplicate_message"> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Country<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control input-sm select2" name="user_country"
                                                id="contry_id" required>
                                                <option value="">Select</option>
                                                <?php
                                                    if (!empty($country_data)) {
                                                        foreach ($country_data as $crow) {
                                                            ?>
                                                <option value="<?= $this->my_encryption->encrypt($crow['RECORD_ID']) ?>"
                                                    <?= (set_select('user_country', $this->my_encryption->encrypt($crow['RECORD_ID']))) ? 'selected' : '' ?>
                                                    <?= $crow['RECORD_ID'] == $user_country ? 'selected' : '' ?>>
                                                    <?= $crow['RECORD_NAME'] ?>
                                                </option>
                                                <?php
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                            <?= form_error('user_country', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                        <div class="col-sm-5">
                                            <select class="form-control input-sm select2" name="user_state"
                                                id="state_value" required>
                                                <option value="">Select</option>

                                            </select>
                                            <?= form_error('user_state', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" minlength="6" maxlength="6"
                                                class="form-control input-sm number" placeholder="Pin Code"
                                                name="user_pincode" value="<?=$user_pincode?>" required>
                                            <?= form_error('user_pincode', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Upload Photo</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm">
                                                <input type="file" id="photoInput" class="form-control input-sm"
                                                    accept=".jpeg,.png,.jpg" name="user_photo"
                                                    value="<?= $user_photo; ?>">
                                                <span class="input-group-btn">
                                                    <button id="upload_btn" type="button" class="btn btn-info btn-flat">
                                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <div>
                                                <input type="hidden" name="existing_photo_path"
                                                    value="<?= $user_photo ?>">
                                                <img id="img_show"
                                                    src="<?=base_url('resources/uploads/user_image/'.$user_photo)?>"
                                                    class="profile-user-img img-responsive"
                                                    style="margin: 10px 0 0 0; width: 150px; height: 150px;">
                                                <span style="color: red">* Only JPEG and PNG files accepted</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Address<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm" name="user_address"
                                        value="<?=$user_address?>" required>
                                    <?= form_error('user_address', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Set Role<span class="required_span">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control input-sm select2" multiple="" name="set_role[]" required>
                                        <option value="">Select</option>
                                        <?php
                                            if (!empty($set_role)) {
                                                foreach ($set_role as $data) {
                                            ?>
                                                    <option value="<?= $this->my_encryption->encrypt($data['UG_ID']) ?>" <?= in_array($this->my_encryption->encrypt($data['UG_ID']), $encrypted_user_role) ? 'selected' : '' ?>>
                                                        <?= $data['USER_GROUP_NAME'] ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?= form_error('set_role', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="float-end">
                    <button type="submit" class="btn btn-success btn-sm float-right"><i
                            class="fa fa-save"></i>&nbsp;<?= $btn?></button>
                </div>
            </div>
            <?= form_close(); ?>
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
    $(document).ready(function() {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');

        $('#upload_btn').on('click', function() {
            var fileInput = $('#photoInput')[0];
            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $('#contry_id').change(function() {
            var country = $(this).val();
            $.ajax({
                url: baseurl + 'Master/fetch_state_data',
                type: 'POST',
                data: {
                    country: country
                },
                dataType: 'json',
                success: function(res) {
                    var options = '<option value="">Select</option>';
                    if (res.status === '1') {
                        var state_code = '<?= $user_state ?>';
                        $.each(res.data, function(key, value) {
                            var selected = (state_code == value.EN_STATE_CODE) ?
                                'selected' : '';
                            options += '<option value="' + value.EN_STATE_CODE +
                                '"' + selected + '>' + value.STATE_NAME +
                                '</option>';
                        });
                    }
                    $('#state_value').html(options);
                },
            });
        });
        <?php
         if ($user_country) { ?>
        $('#contry_id').trigger('change');
        <?php
         } ?>

    });

    function enforceLowercaseEmail(event) {
        var input = event.target;
        input.value = input.value.toLowerCase();
    }

    function duplicate_checking(event, input, type) {
        event.preventDefault();
        var inputValue = $(input).val();
        $.ajax({
            url: baseurl + 'User/duplicate_checking_user_master',
            type: 'POST',
            dataType: 'json',
            data: {
                type: type,
                value: inputValue
            },
            success: function(response) {
                if (response.status == 1) {
                    if (type === 'MOBILE') {
                        $('#duplicateMessage').html("Duplicate Contact Number found");
                        $('#contact_no').val('');
                    } else if (type == 'EMAIL') {
                        $('#duplicate_message').html("Duplicate email id found");
                        $('#email_id').val('');
                    } else {
                        $('#duplicateMessage').html("");
                        $('#duplicate_message').html("")
                    }
                } else {
                    $('#duplicateMessage').html("");
                    $('#duplicate_message').html("");
                }
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
    </script>