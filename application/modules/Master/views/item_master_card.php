<?php
if (!empty($single_item_data) && $single_item_data != false) {

    $record_id = $this->my_encryption->encrypt($single_item_data->RECORD_ID);
    $item_type_id = $single_item_data->MASTER_PARENT_RECORD_ID;
    $item_category_id = $this->my_encryption->encrypt($single_item_data->PARENT_RECORD_ID);
    $item_name= $single_item_data->RECORD_NAME;
    $item_details=$single_item_data->DESC_1;
    $uom_id=$this->my_encryption->encrypt($single_item_data->DESC_2);
    $manufacturer_id =$this->my_encryption->encrypt($single_item_data->DESC_3);
    $readonly = "disabled";
    $btn = 'Update';
} else {
    $record_id = '';
    $item_type_id = '';
    $item_category_id = set_value('item_category_name');
    $item_name = '';
    $item_details = '';
    $uom_id = set_value('uom');
    $manufacturer_id = set_value('manufacturer');
    $readonly = "";
    $btn = 'Save';
}

?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?=base_url('view-item');?>"><i class="fa fa-list"></i> View
                        Item</a>
                </div>
                <?= form_open('Master/item_master_card_insert'); ?>
                    <div class="box-body">
                        <input type="hidden" name="record_id"  value="<?= $record_id ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Item Type <span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" id="item_type" name="item_type" <?= $readonly?> required>
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($item_type)) {
                                        foreach ($item_type as $brow) {
                                            ?>
                                            <option value="<?= $this->my_encryption->encrypt($brow['RECORD_ID']) ?>"
                                                <?= (set_select('item_type', $this->my_encryption->encrypt($brow['RECORD_ID']))) ? 'selected' : '' ?>
                                                <?= $brow['RECORD_ID'] == $item_type_id ? 'selected' : '' ?>>
                                                <?= $brow['RECORD_NAME'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                                <?=form_error('item_type', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-1">Item Category <span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" name="item_category_name" id="item_category" required>
                                    <option value="">Select</option>
                                    </select>
                                <?=form_error('item_category_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-1">Item Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm" id="subcategory" autocomplete="off"
                                    name="item_name" value="<?= set_value('item_name'); ?><?= $item_name;?>" required>
                                <?=form_error('item_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="row  mt-2">

                            <div class="col-md-4">
                                <label class="mb-1">Item Details</label>
                                <input type="text" class="form-control input-sm" id="item-details" name="item_details"
                                    value="<?= set_value('item_details'); ?><?= $item_details;?>">
                                <?=form_error('item_details', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" id="selected_uom_id" value="<?= $uom_id; ?>">
                                <label class="mb-1">UOM <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <select class="form-control input-sm select2" id="uom_id" name="uom" required>
                                        
                                        </select>
                                        <?=form_error('uom', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-blue btn-sm" data-placement="top" title="Add New Uom" data-toggle="modal" data-target="#uomModal">
                                            <i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" id="selected_manufacturer_id" value="<?= $manufacturer_id; ?>">
                                <label class="mb-1">Manufacturer <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <select class="form-control input-sm select2" id="manufacturer_id" name="manufacturer" required>
                                        </select>
                                        <?=form_error('manufacturer', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-blue btn-sm" data-placement="top" title="Add New Manufacturer" data-toggle="modal" data-target="#manufacturerModal">
                                            <i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row  mt-2">
                            <div class="col-md-4" id="lowqty" style="display: none;">
                                <label class="mb-1">Low Qty Level <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm number">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="float-end">
                            <button type="submit" class="btn btn-success btn-sm float-right"><i
                                    class="fa fa-save"></i>&nbsp;<?=$btn?></button>
                        </div>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>




<?= $this->load->view($uom_modal); ?>
<?= $this->load->view($manufacturer_modal); ?>

<script>
    $(document).ready(function() {
    var selectedManufacturerId = $('#selected_manufacturer_id').val();
    var selectedUomId = $('#selected_uom_id').val();
    manufacturer_bind(selectedManufacturerId);
    uom_bind(selectedUomId);
    $('#item_type').change(function () {
            var item_category = $(this).val();
            $.ajax({
                url: baseurl + 'Master/fetch_item_category_data',
                type: 'POST',
                data: {
                    item_category: item_category
                },
                dataType: 'json',
                success: function (res) {
                    var options = '<option value="">Select</option>';
                    if (res.status === '1') {
                        var item_category_code = '<?= $item_category_id ?>';
                        $.each(res.data, function (key, value) {
                            var selected = (item_category_code == value.EN_RECORD_ID) ? 'selected' : '';
                            options += '<option value="' + value.EN_RECORD_ID + '" ' + selected + '>' + value.RECORD_NAME + '</option>';
                        });
                    }
                    $('#item_category').html(options);
                    $('#item_category').trigger('change');
                },
            });
    });
    <?php
    if ($item_type_id) { ?>
            $('#item_type').trigger('change');
        <?php
    } ?>
});

function uom_bind(selectedUomId) {
    $.ajax({
        url: baseurl + 'Master/uom_data_bind',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
            let select = $('#uom_id');
            select.empty();
            select.append('<option value="">Select</option>');
            data.forEach(function (item) {
                let isSelected = item.EN_RECORD_ID == selectedUomId;
                select.append($('<option>', {
                    value: item.EN_RECORD_ID,
                    text: item.RECORD_NAME,
                    selected: isSelected
                }));
                
            });
        },
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}

function manufacturer_bind(selectedManufacturerId) {
    $.ajax({
        url: baseurl + 'Master/manufacturer_data_bind',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
            let select = $('#manufacturer_id');
            select.empty();
            select.append('<option value="">Select</option>');
            select.append(selectedManufacturerId);
            data.forEach(function (item) {
                let isSelected = item.EN_RECORD_ID == selectedManufacturerId;
                select.append($('<option>', {
                    value: item.EN_RECORD_ID,
                    text: item.RECORD_NAME,
                    selected: isSelected
                }));
                
            });
        },
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}
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