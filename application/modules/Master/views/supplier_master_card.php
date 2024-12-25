<?php
if (!empty($single_supplier_data) && $single_supplier_data != false) {
    $supplier_id = $this->my_encryption->encrypt($single_supplier_data->RECORD_ID);
    $supplier_name = $single_supplier_data->RECORD_NAME;
    $supplier_phoneno = $single_supplier_data->DESC_1;
    $supplier_person = $single_supplier_data->DESC_2;
    $supplier_email = $single_supplier_data->DESC_3;
    $supplier_address1 = $single_supplier_data->DESC_4;
    $supplier_address2 = $single_supplier_data->DESC_5;
    $supplier_country = $single_supplier_data->DESC_6;
    $supplier_state =$this->my_encryption->encrypt( $single_supplier_data->DESC_7);
    $supplier_district =$this->my_encryption->encrypt( $single_supplier_data->DESC_8);
    $supplier_pincode = $single_supplier_data->DESC_9;
    $btn = 'Update';

} else {
    $supplier_id = '';
    $supplier_name = '';
    $supplier_phoneno = '';
    $supplier_person = '';
    $supplier_email = '';
    $supplier_address1 = '';
    $supplier_address2 = '';
    $supplier_country = set_value("country");
    $supplier_state = set_value('state');
    $supplier_district = set_value('district');
    $supplier_pincode = '';
    $btn = 'Save';
}
?>

<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border ">
                <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-supplier') ?>"><i
                        class="fa fa-list"></i>
                    View
                    Supplier</a>
            </div>
            <?= form_open('Master/save_supplier_master_data'); ?>
            <div class="box-body">
                <input type="hidden" name="supplier_id" id="supplier_id" value="<?= $supplier_id ?>">
                <div class="row">
                    <div class="col-md-6">
                        <label class="mb-1">Supplier Shop Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="supplier_shop_name"
                            value="<?= $supplier_name ?><?= set_value('supplier_shop_name'); ?>" required>
                        <?= form_error('supplier_shop_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>
                    <div class="col-md-6 ">
                        <label class="mb-1">Supplier Contact Person<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="supplier_contact_person"
                            value="<?= $supplier_person ?><?= set_value('supplier_contact_person'); ?>" required
                            onkeypress="return /[a-zA-Z\s]/i.test(event.key)">
                        <?= form_error('supplier_contact_person', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>


                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="mb-1">Supplier Contact No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm number" minlength="10"
                            name="supplier_contact_no"
                            value="<?= $supplier_phoneno ?><?= set_value('supplier_contact_no'); ?>"
                            onkeypress="return isonlyNumberKey(event)" required>
                        <?= form_error('supplier_contact_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email"
                            value="<?= $supplier_email ?><?= set_value('email'); ?>"
                            oninput="enforceLowercaseEmail(event)">
                        <?= form_error('email', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="mb-1">Address Line - 1<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm " name="address_one"
                            value="<?= $supplier_address1 ?><?= set_value('address_one'); ?>" required>
                        <?= form_error('address_one', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Address Line - 2</label>
                        <input type="text" class="form-control form-control-sm " name="address_two"
                            value="<?= $supplier_address2 ?><?= set_value('address_two'); ?>">
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="mb-1">Country<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="country" id="contry_id" required>
                            <option value="">Select</option>
                            <?php
                                    if (!empty($contry_data)) {
                                        foreach ($contry_data as $srow) {
                                            ?>
                            <option value="<?= $this->my_encryption->encrypt($srow['RECORD_ID']) ?>"
                                <?= (set_select('country', $this->my_encryption->encrypt($srow['RECORD_ID']))) ? 'selected' : '' ?>
                                <?= $srow['RECORD_ID'] == $supplier_country ? 'selected' : '' ?>>
                                <?= $srow['RECORD_NAME'] ?>
                            </option>
                            <?php
                                        }
                                    }
                                    ?>
                        </select>
                        <?= form_error('country', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">State<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="state" id="state_value" required>
                            <option value="">Select</option>

                        </select>
                        <?=form_error('state', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-md-6">
                        <label class="mb-1">District<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="district" id="district_value" required>
                            <option value="">Select</option>

                        </select>
                        <?=form_error('district', '<div class="text-danger text-capitalize">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Pincode<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm number" maxlength="6" minlength="6"
                            name="pincode" value="<?= $supplier_pincode ?><?=set_value('pincode'); ?>" required>
                        <?=form_error('pincode', '<div class="text-danger text-capitalize">', '</div>'); ?>
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
                    var state_code = '<?= $supplier_state ?>';
                    $.each(res.data, function(key, value) {
                        var selected = (state_code == value.EN_STATE_CODE) ?
                            'selected' : '';
                        options += '<option value="' + value.EN_STATE_CODE + '" ' +
                            selected + '>' + value.STATE_NAME + '</option>';
                    });
                }
                $('#state_value').html(options);
                $('#state_value').trigger('change');
            },
        });
    });
    $('#state_value').change(function() {
        var state_code = $(this).val();
        $.ajax({
            url: baseurl + 'Master/fetch_district_data',
            type: 'POST',
            data: {
                state_code: state_code
            },
            dataType: 'json',
            success: function(res) {
                var options = '<option value="">Select</option>';
                if (res.status === '1') {
                    var district_code = '<?= $supplier_district ?>';
                    $.each(res.data, function(key, value) {
                        var selected = (district_code == value.EN_DISTRICT_CODE) ?
                            'selected' : ''
                        options += '<option value="' + value.EN_DISTRICT_CODE +
                            '" ' + selected + '>' + value.DISTRICT + '</option>';
                    });
                }
                $('#district_value').html(options);
            },
        });
    });
    <?php 
         if ($supplier_country) 
         { ?>
    $('#contry_id').trigger('change');
    <?php 
        } ?>
});

function enforceLowercaseEmail(event) {
    var input = event.target;
    input.value = input.value.toLowerCase();
}
$(function() {
    'use strict';
    $('[data-toggle="push-menu"]').pushMenu('toggle');
})
</script>