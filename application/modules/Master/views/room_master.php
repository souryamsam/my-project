<?php
if (!empty($single_room_data) && $single_room_data != false) {
    $room_id = $this->my_encryption->encrypt($single_room_data->ROOM_ID);
    $block_id = $this->my_encryption->encrypt($single_room_data->BLOCK_NO);
    $floor_id = $this->my_encryption->encrypt($single_room_data->FLOOR_NO);
    $room_no = $single_room_data->ROOM_NO;
    $room_size = $single_room_data->ROOM_SIZE;
    $room_category_id = $this->my_encryption->encrypt($single_room_data->ROOM_CATEGORY);
    $room_type_id = $this->my_encryption->encrypt($single_room_data->ROOM_TYPE);
    $guest_capacity = $single_room_data->GUEST_CAPACITY;
    $bed_type_id = $this->my_encryption->encrypt($single_room_data->BED_TYPE);
    $ac_room = $single_room_data->AC_ROOM_PRICE;
    $non_ac_room = $single_room_data->NON_AC_ROOM_PRICE;
    $extra_guest = $single_room_data->EXTRA_GUEST;
    $extra_cost = $single_room_data->EXTRA_COST;
    $photo = $single_room_data->PHOTOS;
    $amenities_ids = explode(',', $single_room_data->ROOM_AMINITIES);
    $encrypted_amenities = array_map(function ($id) {
        return $this->my_encryption->encrypt($id);
    }, $amenities_ids);
    $amenities_id = implode(',', $encrypted_amenities);
    $description = $single_room_data->ROOM_DESCRIPTION;
    $btn = 'Update';
} else {
    $room_id = '';
    $block_id = '';
    $floor_id = '';
    $room_no = '';
    $room_size='';
    $room_category_id='';
    $room_type_id= '';
    $guest_capacity='';
    $bed_type_id= '';
    $ac_room = '';
    $non_ac_room='';
    $extra_guest = '';
    $extra_cost='';
    $photo = '';
    $amenities_id = set_value('amenities[]');
    $description = '';
    $btn = 'Save';
}
?>
<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-room')?>"><i class="fa fa-list"></i> View Room Register</a>
                </div>
                <form action="<?=base_url('Master/save_room_master')?>" method = "POST" id="room_master_form">
                    <div class="box-body">
                         <input type="hidden" name="room_id" value="<?= $room_id?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="mb-1">Block No.<span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" name="block_no" >
                                    <option value="">Select</option>
                                    <?php
                                    if(!empty($block_data)){
                                        foreach($block_data as $block_val){
                                            ?>
                                            <option value="<?=$this->my_encryption->encrypt($block_val['RECORD_ID'])?>" <?= $this->my_encryption->encrypt($block_val['RECORD_ID']) == $block_id ? 'selected' : '' ?><?= (set_select('block_no', $this->my_encryption->encrypt($block_val['RECORD_ID']))) ? 'selected' : '' ?>>
                                                <?=$block_val['RECORD_NAME']?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('block_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-1">Floor No.<span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" name="floor_no" >
                                <option value="">Select</option>
                                    <?php
                                    if(!empty($floor_data)){
                                        foreach($floor_data as $floor_val){
                                            ?>
                                            <option value="<?=$this->my_encryption->encrypt($floor_val['RECORD_ID'])?>" <?= $this->my_encryption->encrypt($floor_val['RECORD_ID']) == $floor_id ? 'selected' : '' ?> <?= (set_select('floor_no', $this->my_encryption->encrypt($floor_val['RECORD_ID']))) ? 'selected' : '' ?>>
                                                <?=$floor_val['RECORD_NAME']?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('floor_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-1">Room No.<span class="text-danger">*</span></label>
                                <input type="text" id="room_no_id" name="room_no" class="form-control input-sm number" autocomplete="off" value="<?=set_value('room_no')?><?= $room_no; ?>" >
                                <?php echo form_error('room_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="mb-1">Room Size (Sq-ft)<span class="text-danger">*</span></label>
                                <input type="text" name="room_size" class="form-control input-sm number" value="<?=set_value('room_size')?><?= $room_size; ?>" autocomplete="off" placeholder="Sq-ft" >
                                <?php echo form_error('room_size', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Room Category<span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" name="room_category" >
                                <option value="">Select</option>
                                    <?php
                                    if(!empty($room_category_data)){
                                        foreach($room_category_data as $category_val){
                                            ?>
                                            <option value="<?=$this->my_encryption->encrypt($category_val['RECORD_ID'])?>" <?= $this->my_encryption->encrypt($category_val['RECORD_ID']) == $room_category_id ? 'selected' : '' ?>  <?=(set_select('room_category', $this->my_encryption->encrypt($category_val['RECORD_ID']))) ? 'selected' : '' ?>>
                                                <?=$category_val['RECORD_NAME']?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('room_category', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="mb-1">Room Type<span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" name="room_type" id="room_type" >
                                <option value="">Select</option>
                                    <?php
                                    if(!empty($room_type_data)){
                                        foreach($room_type_data as $room_type_val){
                                            ?>
                                            <option value="<?=$this->my_encryption->encrypt($room_type_val['RECORD_ID'])?>" <?= $this->my_encryption->encrypt($room_type_val['RECORD_ID']) == $room_type_id ? 'selected' : '' ?> <?= (set_select('room_type', $this->my_encryption->encrypt($room_type_val['RECORD_ID']))) ? 'selected' : '' ?>>
                                                <?=$room_type_val['RECORD_NAME']?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('room_type', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label class="mb-1">Guest Capacity<span class="text-danger">*</span></label>
                                <input type="text" name="guest_capacity" class="form-control input-sm number" value="<?=set_value('guest_capacity')?><?= $guest_capacity; ?>" autocomplete="off" >
                                <?php echo form_error('guest_capacity', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Bed Type<span class="text-danger">*</span></label>
                                <select class="form-control input-sm select2" name="bed_type" >
                                <option value="">Select</option>
                                    <?php
                                    if(!empty($bed_type_data)){
                                        foreach($bed_type_data as $bed_type_val){
                                            ?>
                                            <option value="<?=$this->my_encryption->encrypt($bed_type_val['RECORD_ID'])?>"  <?= $this->my_encryption->encrypt($bed_type_val['RECORD_ID']) == $bed_type_id ? 'selected' : '' ?> <?= (set_select('bed_type', $this->my_encryption->encrypt($bed_type_val['RECORD_ID']))) ? 'selected' : '' ?>>
                                                <?=$bed_type_val['RECORD_NAME']?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('bed_type', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="row">
                                <div class="col-md-6">
                                <label class="mb-1">AC Room Price<span class="text-danger" id="ac_price"></span></label>
                                <input type="text" name="room_price_ac" id="room_price_ac" class="form-control input-sm number text-right" value="<?=set_value('room_price_ac')?><?= $ac_room; ?>" autocomplete="off">
                                <?php echo form_error('room_price_ac', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                                <div class="col-md-6">
                                <label class="mb-1">Non-AC Room Price<span class="text-danger" id="nonac_price"></span></label>
                                    <input type="text" name="room_price_nonac" id="room_price_nonac" class="form-control input-sm number text-right" value="<?=set_value('room_price_nonac')?><?= $non_ac_room; ?>" autocomplete="off">
                                    <?php echo form_error('room_price_nonac', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label>Extra Guests<span class="text-danger">*</span></label>
                                <select class="form-control input-sm" id="extramattress" name="extra_guests" >
                                    <option value="">Select</option>
                                    <option value="YES"<?= ($extra_guest == 'YES' || set_select('extra_guests', 'YES')) ? 'selected' : '' ?>>Yes</option>
                                    <option value="NO" <?= ($extra_guest == 'NO' || set_select('extra_guests', 'NO')) ? 'selected' : '' ?>>No</option>
                                </select>
                                <?php echo form_error('extra_guests', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2" id="costmattress" style="display: none;">
                                <label>Extra Cost<span class="text-danger">*</span></label>
                                <input type="text" name="extra_cost" class="form-control input-sm number" value="<?=set_value('extra_cost')?> <?= $extra_cost;?>" required>
                                <?php echo form_error('extra_cost', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Upload Photos</label>
                                <div class="file">
                                    <div class="file__input" id="file__input">
                                        <input id="room_image" class="file__input--file" type="file" multiple name="room_image[]" accept="image/*" >
                                        <label class="file__input--label" for="room_image" data-text-btn="Upload">Add file:</label>
                                    </div>
                                </div>
                                <!-- <input type="hidden" id="room_photo" name="room_photo" value="<?=set_value('room_photo')?>"> -->
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Room Amenities<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="hidden" id="selected_amenities_id" value="<?=$amenities_id; ?>" >
                                        <select class="form-control input-sm select2" id="room_amenities" name="amenities[]" multiple="multiple" >
                        
                                        </select>
                                        <?php echo form_error('amenities[]', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success btn-sm addbtn" style="margin-left: -16px;"
                                            data-placement="top" title="Add New Amenities" data-toggle="modal"
                                            data-target="#room_amenities_modal">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="mb-1">Description</label>
                                <input type="hidden" name="room_desc_val" id="room_desc_val" value="<?= set_value('room_desc_val');?>">
                                <div id="room_desc" class="form-control BalloonEditor" style="border:solid 1px #d2d6de;max-height:100px;"><div><?= $description; ?><?= set_value('room_desc_val'); ?></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="float-end">
                            <button type="submit" class="btn btn-success btn-sm float-right"><i
                                    class="fa fa-save"></i>&nbsp;<?= $btn?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->load->view($room_amenities_modal); ?>
<script>
    <?php
    if ($this->session->flashdata('message')) {
        $msg = $this->session->flashdata('message');
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
            });
            <?php
        }
        unset($_SESSION["msg"]);
    }
    ?>

    $(document).ready(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
        $('[title]').tooltip();
        $('.addbtn').on('click', function () {
            $(this).tooltip('hide');
        });
        var room_amenities_id=$('#selected_amenities_id').val();
        room_amenities_bind(room_amenities_id);
        let room_desc_val;
        BalloonEditor
            .create(document.querySelector('#room_desc'), {
        })   
        .then(room_desc_text => {
            room_desc_val = room_desc_text;
        })
        .catch( error => {
            console.log( error );
        });

        $('#room_master_form').on('submit',function(){
            $('#room_desc_val').val(room_desc_val.getData());
            return true;
        });

        $("#room_image").on('change', function (e) {
            var formData = new FormData();
            var totalFiles = e.target.files.length;

            for (let i = 0; i < totalFiles; i++) { 
                var file = e.target.files[i];
                formData.append('room_image[]', file);

                var reader = new FileReader();
                reader.onload = (function (fileName) {
                    return function (e) {
                        var filePreview = e.target.result;

                        $("<div class='file__value'>" +
                            "<a href='" + filePreview + "' data-lightbox='uploaded-photos' data-title='" + fileName + "'>" +
                            "<img src='" + filePreview + "' alt='" + fileName + "' class='file__preview' style='width: 40px; height: 38px; margin-right: 10px; border-radius: 8px;' />" +
                            "</a>" +
                            "<div class='file__value--text'>" + fileName + "</div>" +
                            "<input type='hidden' class='room_photo' name='room_photo[]' value='<?=set_value('room_photo[]')?>'>" +
                            "<div class='file__value--remove' data-id='" + fileName + "' style='cursor: pointer;color:red'>X</div>" +
                            "</div>").insertAfter('#file__input');
                    };
                })(file.name); 

                reader.readAsDataURL(file);
            }

            // AJAX request to upload images
            $.ajax({
                method: 'post',
                url: baseurl + 'Master/upload_room_image',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    console.log(result);
                    if (result.status == '1') {
                        result.file_name.forEach(function (fileName, index) {
                            $(".room_photo").eq(index).val(fileName);
                        });
                        $.toast({
                            heading: "Success!",
                            text: result.message,
                            showHideTransition: "fade",
                            position: "top-right",
                            icon: "success",
                            loader: true,
                            timeout: 30000
                        });
                    } else {
                        $.toast({
                            heading: "Warning",
                            text: result.message,
                            showHideTransition: "fade",
                            position: "top-right",
                            icon: "error",
                            loader: true,
                            timeout: 30000
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
            });
        });

        // Event listener for removing files
        $(document).on('click', '.file__value--remove', function () {
            $(this).closest('.file__value').remove();
        });


        $("#room_amenities").select2({
            maximumSelectionLength: Infinity
        });

        

        $("#extramattress").change(function () {
            var selectedvalue = $(this).val();
            if (selectedvalue == "YES") {
                $("#costmattress").show();
            }
            else {
                $("#costmattress").hide();
                $("input[name='extra_cost']").val('0.00');
            }
        });

        $("#room_type").change(function () {
            var selectedvalue = $(this).val();
            if (selectedvalue == "TllDZGlYWXpuVkUrV3k5WTM3djlGQT09") {
                $("#ac_price,#nonac_price").html('*');
                $("#room_price_ac,#room_price_nonac").prop('readonly', false);
                $("#room_price_ac,#room_price_nonac").prop('required', true);
            }
            else if(selectedvalue == "NW1paFZPWlFLcUlvQTFjODJ0d0c1Zz09"){
                $("#room_price_ac").prop('readonly', true);
                $("#room_price_nonac").prop('readonly', false);
                $("#room_price_ac").prop('required', false);
                $("#room_price_nonac").prop('required', true);
                $("#ac_price").html('');
                $("#nonac_price").html('*');

            }else{
                $("#ac_price,#nonac_price").html('');
                $("#room_price_ac,#room_price_nonac").prop('readonly', false);
                $("#room_price_ac,#room_price_nonac").prop('required', false);
            }
        });
    
    
        $('#room_no_id').on('keyup', function () {
            var room_number = $(this).val();
                $.ajax({
                    url: baseurl + 'Master/room_number_duplicate_check',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        room_number: room_number,
                    },
                    success: function (response) {
                        if (response.status == '1') {
                            $.toast({
                                heading: "Warning",
                                text: response.message,
                                showHideTransition: "fade",
                                position: "top-right",
                                icon: "error",
                                loader: true,
                                timeout: 3000
                            });
                            $('#room_no_id').val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', status, error);
                    }
                });
        });
    });
    
 function room_amenities_bind(room_amenities_id) {
    if(room_amenities_id){
        let amenitiesArray = room_amenities_id.split(',');
        $.ajax({
            url: baseurl + 'Master/room_amenities_bind',
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                let select = $('#room_amenities');
                select.empty();
                data.forEach(function (item) {
                    let option = $('<option>', {
                        value: item.EN_RECORD_ID,
                        text: item.RECORD_NAME
                    });
                    if ($.inArray(item.EN_RECORD_ID, amenitiesArray) !== -1) {
                        option.prop('selected', true);
                    }
                    select.append(option);
                });
                select.trigger('change');
            },
            error: function(xhr, status, error) {
                console.error('Error occurred:', status, error);
            }
        });
    } else {
        $.ajax({
            url: baseurl + 'Master/room_amenities_bind',
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                let select = $('#room_amenities');
                select.empty();
                data.forEach(function (item) {
                    let option = $('<option>', {
                        value: item.EN_RECORD_ID,
                        text: item.RECORD_NAME
                    });
                    select.append(option);
                });
                select.trigger('change');
            },
            error: function(xhr, status, error) {
                console.error('Error occurred:', status, error);
            }
        });
    }
}

</script>