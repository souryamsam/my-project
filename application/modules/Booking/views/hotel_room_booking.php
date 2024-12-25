<?php
$selected_room = $this->session->userdata('selected_room');
if (isset($_POST["search_room"]) && $_POST["search_room"] == 'search_hotel_room') {
    $no_of_adults = $_POST['no_of_adults'];
    $no_of_childs = $_POST['no_of_childs'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $room_category = isset($_POST['room_category']) ? $_POST['room_category'] : '';
    $room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';
} else {
    $no_of_adults = '';
    $no_of_childs = '';
    $room_category = '';
    $room_type = '';
    $check_in_date = date("d-m-Y");
    $check_out_date = date("d-m-Y", strtotime("+1 day")) ;
}

$check_in = new DateTime($check_in_date);
$check_out = new DateTime($check_out_date);

$interval = $check_in->diff($check_out);
$total_days = $interval->days;

?>
<section class="content">
    <div class="row">
        <div class="col-md-2">
            <div class="box box-primary">
                <?= form_open(base_url('hotel-room-booking'), array('id' => 'searchHotelRoomForm')) ?>
                <div class="box-body">
                    <input type="hidden" name="search_room" value="search_hotel_room" />
                    <div class="form-group">
                        <label>No of Adults<span class="required"></span></label>
                        <div class="input-group">
                            <input type="number" class="form-control input-sm number" name="no_of_adults"
                                value="<?= $no_of_adults ?>" placeholder="No. of Adults" min="1"
                                required>
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-male"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No of Childs<span class="required"></span></label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control input-sm number" name="no_of_childs"
                                value="<?= $no_of_childs ?>" placeholder="No. of Childs" min="0"
                                required>
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-child"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Check-In Date<span class="required"></span></label>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm datepicker" name="check_in_date" id="check_in_date"
                            value="<?= $check_in_date ?>" placeholder="Check In Date" required>
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-check-o"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Check-Out Date<span class="required"></span></label>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm datepicker" name="check_out_date" id="check_out_date"
                                min="<?=date("d-m-Y")?>" value="<?= $check_out_date ?>" placeholder="Check Out Date"
                                aria-describedby="basic-addon2" required>
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-times-o"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success btn-sm pull-right search">
                        <i class="fa fa-search"></i>&nbsp;Search</button>
                </div>
            </div>
            <?php
            if (isset($_POST["search_room"]) && $_POST["search_room"] == 'search_hotel_room') {
                ?>
                <div class="box box-primary" id="filterbox" style="display: block;">
                    <div class="box-header with-border">
                        <h4 class="box-title">Filters</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Room Category</label>
                            <select class="form-control select2" name="room_category" tabindex="-1" aria-hidden="true">
                                <option value="">Select</option>
                                <?php
                                if (!empty($room_category_data)) {
                                    foreach ($room_category_data as $room_category) {
                                        ?>
                                        <option value="<?= $this->my_encryption->encrypt($room_category['RECORD_ID']) ?>"
                                            <?= ($this->my_encryption->encrypt($room_category['RECORD_ID']) == $room_category) ? 'selected' : '' ?>>
                                            <?= $room_category['RECORD_NAME'] ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Room Type</label>
                            <select class="form-control select2" name="room_type">
                                <option value="">All</option>
                                <?php
                                if (!empty($room_type_data)) {
                                    foreach ($room_type_data as $room_type) {
                                        ?>
                                        <option value="<?= $this->my_encryption->encrypt($room_type['RECORD_ID']) ?>"
                                            <?= $this->my_encryption->encrypt($room_type['RECORD_ID']) == $room_type ? 'selected' : '' ?>>
                                            <?= $room_type['RECORD_NAME'] ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-sm btn-danger pull-right">
                            <i class="fa fa-filter"></i>&nbsp;Search</button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?= form_close() ?>
        <?php
        if (isset($_POST["search_room"]) && $_POST["search_room"] == 'search_hotel_room') {
            ?>
            <div class="col-md-10">
            <?= form_open(base_url('Booking/room_booking_cart')); ?>
                <div class="box box-primary" id="Search-Results" style="display: block;">
                    <div class="box-header with-border">
                    <h3 class="box-title">Search Results For [<?=$check_in_date .' - '. $check_out_date?>]: Total Days: <?=$total_days?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="overflow-x: auto; width: 100%;">
                                            <table class="table table-condensed table-bordered roominfotable"
                                                style="width: 100%; table-layout: fixed;">

                                                <tbody>
                                                    <?php
                                                    array_pop($available_dates);
                                                    if (!empty($available_dates)) {
                                                    ?>
                                                    <tr class="bg-info" style="font-weight:600">
                                                        <td id="room-info-header" style="white-space: nowrap;">
                                                            Room Info
                                                        </td>
                                                        <?php
                                                        
                                                            foreach ($available_dates as $dates) {
                                                                $show_date = date("d-m-Y", strtotime($dates['AVAILABLE_DATES']));
                                                                ?>
                                                                <td style="width: 170px; text-align: center;">
                                                                    <span id="ContentPlaceHolder1_listDays_lblDate_0">
                                                                        <?= $show_date ?>
                                                                    </span>
                                                                </td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <?php
                                                    }
                                                    if (!empty($room_data)) {
                                                        foreach ($room_data as $room) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="hidden" id="room_id<?= $room['ROOM_NO']?>" value="<?= $room['ROOM_ID'] ?>" >
                                                                    <input type="hidden" id="extra_cost<?= $room['ROOM_NO']?>" value="<?= $room['EXTRA_COST'] ?>" >
                                                                    <span style="text-shadow: 0 0 16px rgba(0, 0, 0, .2);" id="room_no<?= $room['ROOM_NO'] ?>"><?= $room['ROOM_NO'] ?></span><br>
                                                                    <span id="bed_type<?= $room['ROOM_NO'] ?>"><?= $room['BED_TYPE_NAME'] ?></span>
                                                                    (<span id="room_category<?= $room['ROOM_NO'] ?>"><?= $room['ROOM_CATEGORY_NAME'] ?></span>)
                                                                    <br>
                                                                        <i class="fa fa-building-o"></i>
                                                                        <span id="floor<?= $room['ROOM_NO'] ?>"><?= $room['FLOOR_NAME'] ?></span>
            
                                                                    
                                                                    <br>
                                                                        AC - <i class="fa fa-inr"></i>
                                                                        <span id="ac_rent<?= $room['ROOM_NO'] ?>"><?= $room['AC_ROOM_PRICE'] ?></span>
                                                                        <i style="color: #11a400" class="fa fa-square" aria-hidden="true"></i>
                                                                    
                                                                    <br>
                                                                        Non AC - <i class="fa fa-inr"></i>
                                                                        <span id="nonac_rent<?= $room['ROOM_NO'] ?>"><?= $room['NON_AC_ROOM_PRICE'] ?></span>
                                                                        <i class="fa fa-square" style="color: #ff0000" aria-hidden="true"></i>
                                                                        
                                                                    <br>
                                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#room-amenities<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>"
                                                                        title="Click to Check Room Amenities"><i class="fa fa-info"></i></a>
                                                                </td>
                                                                <?php
                                                                if (!empty($available_dates)) {
                                                                    foreach ($available_dates as $key => $dates) {
                                                                        $show_date = date("d-m-Y", strtotime($dates['AVAILABLE_DATES']));
                                                                        ?>
                                                                        <td>
                                                                            <input type="hidden" id="available_date<?= $room['ROOM_NO'] . $key?>" value="<?= $show_date?>">
                                                                            <?php if ($room['ROOM_TYPE_NAME'] == 'NON-AC') { ?>
                                                                                <div class="selector">
                                                                                    <div class="selector-item">
                                                                                        <input type="checkbox"
                                                                                            id="non_ac_checkbox<?= $room['ROOM_NO'] . $key ?>"
                                                                                            data-room_id="<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>"
                                                                                            class="selector-item_checkbox non-ac-checkbox"
                                                                                            value="NON-AC">
                                                                                        <label
                                                                                            for="non_ac_checkbox<?= $room['ROOM_NO'] . $key ?>"
                                                                                            class="selector-item_label non-ac"> NON-AC
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="selector">
                                                                                    <div class="selector-item">
                                                                                        <input type="checkbox"
                                                                                            id="accheckbox<?= $room['ROOM_NO'] . $key ?>"
                                                                                            data-room_id="<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>"
                                                                                            class="selector-item_checkbox ac-checkbox"
                                                                                            value="AC">
                                                                                        <label
                                                                                            for="accheckbox<?= $room['ROOM_NO'] . $key ?>"
                                                                                            class="selector-item_label ac">
                                                                                            AC
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="selector-item">
                                                                                        <input type="checkbox"
                                                                                            id="nonaccheckbox<?= $room['ROOM_NO'] . $key ?>"
                                                                                            data-room_id="<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>"
                                                                                            class="selector-item_checkbox non-ac-checkbox"
                                                                                            value="NON-AC">
                                                                                        <label
                                                                                            for="nonaccheckbox<?= $room['ROOM_NO'] . $key ?>"
                                                                                            class="selector-item_label non-ac">
                                                                                            NON-AC
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <h5 class="text-center"><b>Extra Mattress</b></h5>
                                                                            <div class="selector">
                                                                                <div class="selector-item">
                                                                                    <input type="checkbox"
                                                                                        id="checkYes<?= $room['ROOM_NO'] . $key ?>"
                                                                                        data-room_id="<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>"
                                                                                        class="selector-item_checkbox yes-checkbox"
                                                                                        value="YES" disabled>
                                                                                    <label for="checkYes<?= $room['ROOM_NO'] . $key ?>"
                                                                                        class="selector-item_label yes"> Yes </label>
                                                                                </div>
                                                                                <div class="selector-item">
                                                                                    <input type="checkbox"
                                                                                        id="checkNo<?= $room['ROOM_NO'] . $key ?>"
                                                                                        data-room_id="<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>"
                                                                                        class="selector-item_checkbox no-checkbox"
                                                                                        value="NO" disabled>
                                                                                    <label for="checkNo<?= $room['ROOM_NO'] . $key ?>"
                                                                                        class="selector-item_label no">No</label>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" class="h_check_val" name="room_id[]" id="room_id<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="room_no[]" id="room_no<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="bed_type[]" id="bed_type<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="room_category[]" id="room_category<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="room_type[]" id="room_type<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="ac_rent[]" id="ac_rent<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="nonac_rent[]" id="nonac_rent<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="mattres[]" id="mattres<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="extra_cost[]" id="extra_cost<?= $room['ROOM_NO'] . $key ?>" >
                                                                            <input type="hidden" class="h_check_val" name="room_date[]" id="room_date<?= $room['ROOM_NO'] . $key ?>" >
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $("#checkYes<?= $room['ROOM_NO'] . $key ?>, #checkNo<?= $room['ROOM_NO'] . $key ?>" ).click(function(){
                                                                                    var mattres = $(this).val();
                                                                                    if($(this).is(':checked')){
                                                                                        $("#mattres<?= $room['ROOM_NO'] . $key ?>").val(mattres);
                                                                                    }else{
                                                                                        $("#mattres<?= $room['ROOM_NO'] . $key ?>").val('');
                                                                                    }
                                                                                    
                                                                                });
                                                                                $("#accheckbox<?= $room['ROOM_NO'] . $key ?>, #nonaccheckbox<?= $room['ROOM_NO'] . $key ?>, #non_ac_checkbox<?= $room['ROOM_NO'] . $key ?> " ).click(function(){
                                                                                    var room_type = $(this).val();
                                                                                    var room_id = $('#room_id<?= $room['ROOM_NO']?>').val();
                                                                                    var extra_cost = $('#extra_cost<?= $room['ROOM_NO']?>').val();
                                                                                    var room_number = $('#room_no<?= $room['ROOM_NO']?>').text();
                                                                                    var bed_type = $('#bed_type<?= $room['ROOM_NO']?>').text();
                                                                                    var room_category = $('#room_category<?= $room['ROOM_NO']?>').text();
                                                                                    var ac_rent = $('#ac_rent<?= $room['ROOM_NO']?>').text();
                                                                                    var nonac_rent = $('#nonac_rent<?= $room['ROOM_NO']?>').text();
                                                                                    var mattres = $("#checkNo<?= $room['ROOM_NO'] . $key ?>").val();
                                                                                    var available_date = $('#available_date<?= $room['ROOM_NO'] . $key ?>').val();
                                                                                    if($(this).is(':checked')){
                                                                                        $("#checkYes<?= $room['ROOM_NO'] . $key ?>").prop('disabled', false);
                                                                                        $("#checkNo<?= $room['ROOM_NO'] . $key ?>").prop('disabled', false);
                                                                                        $("#checkYes<?= $room['ROOM_NO'] . $key ?>").prop('checked', false);
                                                                                        $("#checkNo<?= $room['ROOM_NO'] . $key ?>").prop('checked', true);
                                                                                        $("#room_id<?= $room['ROOM_NO'] . $key ?>").val(room_id);
                                                                                        $("#room_no<?= $room['ROOM_NO'] . $key ?>").val(room_number);
                                                                                        $("#bed_type<?= $room['ROOM_NO'] . $key ?>").val(bed_type);
                                                                                        $("#room_category<?= $room['ROOM_NO'] . $key ?>").val(room_category);
                                                                                        $("#room_type<?= $room['ROOM_NO'] . $key ?>").val(room_type);
                                                                                        $("#ac_rent<?= $room['ROOM_NO'] . $key ?>").val(ac_rent);
                                                                                        $("#nonac_rent<?= $room['ROOM_NO'] . $key ?>").val(nonac_rent);
                                                                                        $("#mattres<?= $room['ROOM_NO'] . $key ?>").val(mattres);
                                                                                        $("#extra_cost<?= $room['ROOM_NO'] . $key ?>").val(extra_cost);
                                                                                        $("#room_date<?= $room['ROOM_NO'] . $key ?>").val(available_date);
                                                                                    } else {
                                                                                        $("#checkYes<?= $room['ROOM_NO'] . $key ?>").prop('disabled', true);
                                                                                        $("#checkNo<?= $room['ROOM_NO'] . $key ?>").prop('disabled', true);
                                                                                        $("#checkYes<?= $room['ROOM_NO'] . $key ?>").prop('checked', false);
                                                                                        $("#checkNo<?= $room['ROOM_NO'] . $key ?>").prop('checked', false);
                                                                                        $("#room_id<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#room_no<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#bed_type<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#room_category<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#ac_rent<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#nonac_rent<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#mattres<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#extra_cost<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                        $("#room_date<?= $room['ROOM_NO'] . $key ?>").val("");
                                                                                    }
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>
                                                            
                                                            <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <tr>
                                                            <td colspan="12" class="text-danger text-center"><b>No Data Found...</b></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 text-right" >
                            <button type="button" class="btn btn-sm btn-primary" id="reset" style="margin-right: 5px;">
                                <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp;Reset
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i> &nbsp;Add to Cart
                            </button>
                        </div>
                    </div>
                </div> 
                </div>
                <?= form_close(); ?>
            </div>
        <?php
        } else{
            /* echo'<div class="col-md-10">
                    <div class="box box-solid box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">No Hotel Selected</h3>
                        </div>
                        <div class="box-body">
                            <p>Please select a hotel to view the available rooms.</p>
                        </div>
                    </div>
                </div>'; */
        }
        ?>
    </div>
</section>

<!-- Room Amenities Modal -->
<?php
if (!empty($room_data)) {
    foreach ($room_data as $room) {
        ?>
        <div class="modal fade" id="room-amenities<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Room Amenities</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-9">
                                <?php
                                $room_amenities = explode(',', $room['ROOM_AMINITIES_NAME']);
                                foreach ($room_amenities as $amenity) {
                                    ?>
                                    <h4 class="text-center"><?= $amenity ?> :</h4>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                $room_amenities = explode(',', $room['ROOM_AMINITIES_NAME']);
                                foreach ($room_amenities as $amenity) {
                                    if ($amenity == $amenity) {
                                        ?>
                                        <h4 class="text-center"><i class="fa fa-check text-success"></i></h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 class="text-center"><i class="fa fa-times text-danger"></i></h4>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    $(document).ready(function () {
        'use strict';

        // Adjust Room Info Width Function
        function adjustRoomInfoWidth() {
            var searchResults = $('#Search-Results');
            var originalDisplay = searchResults.css('display');

            if (originalDisplay === 'none') {
                searchResults.css('display', 'block');
            }

            var tableWidth = $('.table-responsive .table').outerWidth();
            var containerWidth = $('.table-responsive').outerWidth();

            $('#room-info-header').css('width', tableWidth > containerWidth ? '200px' : 'auto');

            if (originalDisplay === 'none') {
                searchResults.css('display', originalDisplay);
            }
        }

        // Call adjustment on load
        setTimeout(adjustRoomInfoWidth, 0);

        // Adjust on search results transition
        $('#Search-Results').on('transitionend', function () {
            if ($(this).css('display') !== 'none') {
                adjustRoomInfoWidth();
            }
        });

        // Toggle push menu
        $('[data-toggle="push-menu"]').pushMenu('toggle');

        // Single Checkbox Selection within a Group
        $('.selector-item_checkbox').on('change', function () {
            var name = $(this).attr('name');
            if ($(this).is(':checked')) {
                $('input[name="' + name + '"]').not(this).prop('checked', false);
            }
        });

        // Reset Confirmation
        $('#reset').on('click', function () {
            if (confirm('Are you sure you want to reset?')) {
                $('.selector-item_checkbox').prop('checked', false);
                $('.h_check_val').val('');
            }
        });

        $('#check_out_date').on('change', function() {
            var check_in_date = $('#check_in_date').val();
            var check_out_date = $(this).val();

            function formatDate(dateString) {
                return dateString.split('-').reverse().join('-');
            }

            var formattedCheckInDate = formatDate(check_in_date);
            var formattedCheckOutDate = formatDate(check_out_date);

            var checkInDateObj = new Date(formattedCheckInDate);
            var checkOutDateObj = new Date(formattedCheckOutDate);

            if (checkOutDateObj < checkInDateObj) {
                $.toast({
                    heading: "Warning",
                    text: 'Check-out date cannot be earlier than check-in date.',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                $(this).val('');
            } else if (checkOutDateObj.getTime() === checkInDateObj.getTime()) {
                $.toast({
                    heading: "Warning",
                    text: 'Check-in and check-out dates cannot be the same.',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                $(this).val('');
            }
        });

        // AC/Non-AC Checkbox Control
        $('.ac-checkbox').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('td').find('.non-ac-checkbox').prop('checked', false);
            }
        });
        $('.non-ac-checkbox').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('td').find('.ac-checkbox').prop('checked', false);
            }
        });

        // Yes/No Checkbox Control
        $('.yes-checkbox').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('td').find('.no-checkbox').prop('checked', false);
            }
        });
        $('.no-checkbox').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('td').find('.yes-checkbox').prop('checked', false);
            }
        });

        // Flash Message Display
        <?php if ($this->session->flashdata('booking_msg')) {
            $msg = $this->session->flashdata('booking_msg');
            if ($msg["status"] == '1') { ?>
                    swal({
                        title: "Success!",
                        text: "<?= $msg["message"] ?>",
                        icon: "success",
                        button: "OK",
                        timer: 3000
                    });
                <?php } else { ?>
                    swal({
                        title: "Warning",
                        text: "<?= $msg["message"] ?>",
                        icon: "error",
                        button: "OK",
                        timer: 3000
                    });
                <?php }
            unset($_SESSION["booking_msg"]);
     } ?>
    });
</script>

