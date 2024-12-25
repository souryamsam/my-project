<?php
$guest_name = isset($_POST['guest_name']) ? $_POST['guest_name'] : '';
$guest_id = isset($_POST['guest_id']) ? $_POST['guest_id'] : '';
$booking_id = isset($_POST['custom_id']) ? $_POST['custom_id'] : '';
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary" id="Search-Results">
            <?= form_open(base_url('Checkin/room_booking_cart')); ?>
            <input type="hidden" name="guest_id" value="<?=$guest_id?>" />
            <input type="hidden" name="bookin_id" value="<?=$booking_id?>" />
            <div class="box-body">
                <h4 style="margin-top: 0px;">Guest Name : <?= $guest_name ?><small> ( Booking Details )</small></h4>
                <hr style="border-color: rgb(189, 178, 178);margin-top: 5px;">
                <div class="form-group">
                    <div class="table-responsive" style="overflow-x: auto; width: 100%;">
                        <table class="table table-condensed table-bordered roominfotable"
                            style="width: 100%; table-layout: fixed;">
                            <thead class="bg-info">
                                <tr>
                                    <th id="room-info-header" style="white-space: nowrap; width: auto;">
                                        Room Info
                                    </th>
                                    <?php
                                    if (!empty($booking_dates)) {
                                        foreach ($booking_dates as $i => $date) {
                                            ?>
                                            <th style="width: 170px; text-align: center;">
                                                <span><?= date('d/m/Y', strtotime($date['F_DATE'])) ?></span>
                                            </th>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($room_data)) {
                                    foreach ($room_data as $key => $room) {
                                        $room_details = [];

                                        if (!empty($booking_details)) {
                                            foreach ($booking_details as $i => $row) {
                                             
                                                if ($room['ROOM_ID'] == $row['ROOM_ID']) {
                                                    $room_details[] = $row;
                                                }
                                            }
                                        }
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
                                        if (!empty($booking_dates)) {
                                            foreach ($booking_dates as $i => $date) {
                                                $ismatched = false;
                                                if (!empty($room_details)) {
                                                    foreach ($room_details as $i => $details) {
                                                        if($details['F_DATE'] == $date['F_DATE']) {
                                                           $ismatched = true; 
                                                    ?>
                                                    <td>
                                                        <?php if ($room['ROOM_TYPE_NAME'] == 'NON-AC') { ?>
                                                            <div class="selector">
                                                                <div class="selector-item">
                                                                    <input type="checkbox" id="non_ac_checkbox<?=$room['ROOM_NO'].$i?>" 
                                                                        class="selector-item_checkbox non-ac-checkbox" <?=$details['ROOM_TYPE'] == 'NON-AC'?'checked':''?>>
                                                                    <label for="non_ac_checkbox<?=$room['ROOM_NO'].$i?>"class="selector-item_label non-ac"> NON-AC </label>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="selector">
                                                                <div class="selector-item">
                                                                    <input type="checkbox" id="accheckbox<?=$room['ROOM_NO'].$i?>" 
                                                                        class="selector-item_checkbox ac-checkbox" <?=$details['ROOM_TYPE'] == 'AC'?'checked':''?>>
                                                                    <label for="accheckbox<?=$room['ROOM_NO'].$i?>" class="selector-item_label ac">AC</label>
                                                                </div>
                                                                <div class="selector-item">
                                                                    <input type="checkbox" id="nonaccheckbox<?=$room['ROOM_NO'].$i?>" 
                                                                        class="selector-item_checkbox nonac-checkbox" <?=$details['ROOM_TYPE'] == 'NON-AC'?'checked':''?>>
                                                                    <label for="nonaccheckbox<?=$room['ROOM_NO'].$i?>" class="selector-item_label non-ac">NON-AC</label>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <h5 class="text-center"><b>Extra Mattress</b></h5>
                                                        <div class="selector">
                                                            <div class="selector-item">
                                                                <input type="checkbox" id="checkYes<?=$room['ROOM_NO'].$i?>"
                                                                    class="selector-item_checkbox yes-checkbox" <?=$details['EXTRA_MATTRESS_USED'] == 'YES'?'checked':''?>>
                                                                <label for="checkYes<?=$room['ROOM_NO'].$i?>" class="selector-item_label yes">Yes</label>
                                                            </div>
                                                            <div class="selector-item">
                                                                <input type="checkbox" id="checkNo<?=$room['ROOM_NO'].$i?>"
                                                                    class="selector-item_checkbox no-checkbox" <?=$details['EXTRA_MATTRESS_USED'] == 'NO'?'checked':''?>>
                                                                <label for "checkNo<?=$i?>" class="selector-item_label no">No</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="room_id[]" id="room_id<?=$room['ROOM_NO'].$i?>"  value="<?= $room['ROOM_ID'] ?>">
                                                        <input type="hidden" name="room_no[]" id="room_no<?=$room['ROOM_NO'].$i?>" value="<?= $room['ROOM_NO'] ?>">
                                                        <input type="hidden" name="bed_type[]" id="bed_type<?=$room['ROOM_NO'].$i?>" value="<?= $room['BED_TYPE_NAME'] ?>">
                                                        <input type="hidden" name="room_category[]" id="room_category<?=$room['ROOM_NO'].$i?>" value="<?= $room['ROOM_CATEGORY_NAME'] ?>">
                                                        <input type="hidden" name="room_type[]" id="room_type<?=$room['ROOM_NO'].$i?>" value="<?= $room['ROOM_TYPE_NAME'] ?>">
                                                        <input type="hidden" name="ac_rent[]" id="ac_rent<?=$room['ROOM_NO'].$i?>" value="<?= $room['AC_ROOM_PRICE'] ?>">
                                                        <input type="hidden" name="nonac_rent[]" id="nonac_rent<?=$room['ROOM_NO'].$i?>" value="<?= $room['NON_AC_ROOM_PRICE'] ?>">
                                                        <input type="hidden" name="mattres[]" id="mattres<?=$room['ROOM_NO'].$i?>" value="<?=$details['EXTRA_MATTRESS_USED']?>">
                                                        <input type="hidden" name="extra_cost[]" id="extra_cost<?=$room['ROOM_NO'].$i?>" value="<?= $room['EXTRA_COST'] ?>">
                                                        <input type="hidden" name="room_date[]" id="room_date<?=$room['ROOM_NO'].$i?>" value="<?= date('d-m-Y',strtotime($date['F_DATE'])) ?>">
                                                    </td>
                                                    <script>
                                                        $(document).ready(function(){
                                                            $("#checkYes<?=$room['ROOM_NO'].$i?>, #checkNo<?=$room['ROOM_NO'].$i?>" ).click(function(){
                                                                var mattres = $(this).val();
                                                                if($(this).is(':checked')){
                                                                    $("#mattres<?=$room['ROOM_NO'].$i?>").val(mattres);
                                                                }else{
                                                                    $("#mattres<?=$room['ROOM_NO'].$i?>").val('');
                                                                }
                                                            });
                                                            $("#accheckbox<?=$room['ROOM_NO'].$i?>, #nonaccheckbox<?=$room['ROOM_NO'].$i?>, #non_ac_checkbox<?=$room['ROOM_NO'].$i?> " ).click(function(){
                                                                var room_type = $(this).val();
                                                                var room_id = $('#room_id<?= $room['ROOM_NO']?>').val();
                                                                var extra_cost = $('#extra_cost<?= $room['ROOM_NO']?>').val();
                                                                var room_number = $('#room_no<?= $room['ROOM_NO']?>').text();
                                                                var bed_type = $('#bed_type<?= $room['ROOM_NO']?>').text();
                                                                var room_category = $('#room_category<?= $room['ROOM_NO']?>').text();
                                                                var ac_rent = $('#ac_rent<?= $room['ROOM_NO']?>').text();
                                                                var nonac_rent = $('#nonac_rent<?= $room['ROOM_NO']?>').text();
                                                                var mattres = $("#checkNo<?=$i?>").val();
                                                                var available_date = $('#available_date<?=$i?>').val();
                                                                if($(this).is(':checked')){
                                                                    $("#checkYes<?=$room['ROOM_NO'].$i?>").prop('disabled', false);
                                                                    $("#checkNo<?=$room['ROOM_NO'].$i?>").prop('disabled', false);
                                                                    $("#checkNo<?=$room['ROOM_NO'].$i?>").prop('checked', true);
                                                                    $("#room_id<?=$room['ROOM_NO'].$i?>").val(room_id);
                                                                    $("#room_no<?=$room['ROOM_NO'].$i?>").val(room_number);
                                                                    $("#bed_type<?=$room['ROOM_NO'].$i?>").val(bed_type);
                                                                    $("#room_category<?=$room['ROOM_NO'].$i?>").val(room_category);
                                                                    $("#room_type<?=$room['ROOM_NO'].$i?>").val(room_type);
                                                                    $("#ac_rent<?=$room['ROOM_NO'].$i?>").val(ac_rent);
                                                                    $("#nonac_rent<?=$room['ROOM_NO'].$i?>").val(nonac_rent);
                                                                    $("#mattres<?=$room['ROOM_NO'].$i?>").val(mattres);
                                                                    $("#extra_cost<?=$room['ROOM_NO'].$i?>").val(extra_cost);
                                                                    $("#room_date<?=$room['ROOM_NO'].$i?>").val(available_date);
                                                                } else {
                                                                    $("#checkYes<?=$room['ROOM_NO'].$i?>").prop('disabled', true);
                                                                    $("#checkNo<?=$room['ROOM_NO'].$i?>").prop('disabled', true);
                                                                    $("#checkNo<?=$room['ROOM_NO'].$i?>").prop('checked', false);
                                                                    $("#room_id<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#room_no<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#bed_type<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#room_category<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#ac_rent<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#nonac_rent<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#mattres<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#extra_cost<?=$room['ROOM_NO'].$i?>").val("");
                                                                    $("#room_date<?=$room['ROOM_NO'].$i?>").val("");
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                    <?php
                                                    break;
                                                        }
                                                }
                                            }
                                            
                                            if (!$ismatched) {
                                                ?>
                                                <td>
                                                    <input type="hidden" id="available_date<?= $room['ROOM_NO'] . $key?>" value="<?= $date['F_DATE']?>">
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
                                                    <input type="hidden" name="room_id[]" id="room_id<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="room_no[]" id="room_no<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="bed_type[]" id="bed_type<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="room_category[]" id="room_category<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="room_type[]" id="room_type<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="ac_rent[]" id="ac_rent<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="nonac_rent[]" id="nonac_rent<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="mattres[]" id="mattres<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="extra_cost[]" id="extra_cost<?= $room['ROOM_NO'] . $key ?>" >
                                                    <input type="hidden" name="room_date[]" id="room_date<?= $room['ROOM_NO'] . $key ?>" >
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
                                    }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-primary float-right"><i
                                class="fa fa-cart-plus" aria-hidden="true"></i> &nbsp;Proceed to Cart</button>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tableContainer = document.querySelector('.table-responsive');
        var roomInfoHeader = document.getElementById('room-info-header');
        var searchResults = document.getElementById('Search-Results');

        function adjustRoomInfoWidth() {
            var originalDisplay = searchResults.style.display;

            if (originalDisplay === 'none') {
                searchResults.style.display = 'block';
            }

            var tableWidth = tableContainer.querySelector('.table').offsetWidth;
            var containerWidth = tableContainer.offsetWidth;

            if (tableWidth > containerWidth) {
                roomInfoHeader.style.width = '200px';
            } else {
                roomInfoHeader.style.width = 'auto';
            }

            if (originalDisplay === 'none') {
                searchResults.style.display = originalDisplay;
            }
        }

        setTimeout(adjustRoomInfoWidth, 0);

        searchResults.addEventListener('transitionend', function () {
            if (searchResults.style.display !== 'none') {
                adjustRoomInfoWidth();
            }
        });
    });
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');

        $('.ac-checkbox').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('td').find('.nonac-checkbox').prop('checked', false);
            }
        });

        $('.nonac-checkbox').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('td').find('.ac-checkbox').prop('checked', false);
            }
        });

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
    });
</script>