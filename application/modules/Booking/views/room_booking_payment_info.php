<?php
$selected_room = $this->session->userdata('selected_room');
$guest_id = isset($_POST['custom_id']) ? $_POST['custom_id'] : '';
$guest_name = isset($_POST['c_name']) ? $_POST['c_name'] : '';
$guest_email = isset($_POST['c_email']) ? $_POST['c_email'] : '';
$guest_contactNo = isset($_POST['c_contactNo']) ? $_POST['c_contactNo'] : '';
$guest_address = isset($_POST['c_address']) ? $_POST['c_address'] : '';
$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
?>
<?= form_open(base_url('Booking/save_payment_details'), ['id' => 'payment_details_form']) ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1">
                                        <b>Name :</b>
                                    </div>
                                    <div class="col-md-5">
                                        <span><?= $guest_name ?></span>
                                    </div>
                                    <div class="col-md-1">
                                        <b>Contact :</b>
                                    </div>
                                    <div class="col-md-5">
                                        <span id="ContentPlaceHolder1_spContact"><?= $guest_contactNo ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="row">
                                    <?php if($guest_email!=""){ ?>
                                    <div class="col-md-1">
                                        <b>Email :</b>
                                    </div>
                                    <div class="col-md-5">
                                        <span id="ContentPlaceHolder1_spEmail"><?= $guest_email ?></span>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-1">
                                        <b>Address :</b>
                                    </div>
                                    <div class="col-md-5">
                                        <span id="ContentPlaceHolder1_spaddress"><?= $guest_address ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="row">
                                    <div class="col-md-1">
                                        <b>Agent :</b>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" name="customer_id" value="<?= $guest_id ?>" >
                                        <select class="form-control select2 input-sm" name="agent_id">
                                            <option value="">Select</option>
                                            <?php
                                             foreach ($agent_data as $agent) {
                                                ?>
                                                 <option value="<?=$this->my_encryption->encrypt($agent['RECORD_ID'])?>"><?=$agent['RECORD_NAME']?></option>;
                                                 <?php
                                             }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl No</th>
                                                        <th>Room No</th>
                                                        <th>From Date</th>
                                                        <th>To Date</th>
                                                        <th>Days</th>
                                                        <th style="width: 100px;">Extra Mattress</th>
                                                        <th>Mattress Rate</th>
                                                        <th>Room Rate</th>
                                                        <th style="width: 70px;">Total Amount</th>
                                                        <th style="width: 100px;">Final Amount</th>
                                                        <th>Discounted/Added Amount</th>
                                                        <th>Taxable Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        if (!empty($selected_room)) {
                                                            // Group data by room_no and room_type
                                                            $groupedRooms = [];
                                                            foreach ($selected_room as $room) {
                                                                $groupedRooms[$room['room_no']][$room['room_type']][] = $room;
                                                            }
                                                            $i=1;
                                                            foreach ($groupedRooms as $room_no => $roomTypes) {
                                                                foreach ($roomTypes as $room_type => $rooms) {
                                                                    // Dates for first check-in and last check-out
                                                                    $checkInDate = new DateTime($rooms[0]['room_date']);
                                                                    $checkOutDate = new DateTime(end($rooms)['room_date']);
                                                                    
                                                                    if($checkInDate->format('d-m-Y') === date('d-m-Y')){
                                                                        $current_checkin = 'CHECKIN';
                                                                    }else{
                                                                        $current_checkin = '';
                                                                    }

                                                                    $roomDates = array_column($rooms, 'room_date');
                                                                    $uniqueRoomDates = array_unique($roomDates);
                                                                    $totalDays = count($uniqueRoomDates);

                                                                    // Set rent based on room type
                                                                    $rent = ($room_type == 'AC') ? $rooms[0]['ac_rent'] : $rooms[0]['nonac_rent'];
                                                                    $mattressCost = 0.00;

                                                                    // Calculate mattress cost in a single loop
                                                                    foreach ($rooms as $room) {
                                                                        if ($room['mattres'] == 'YES') {
                                                                            $mattressCost += $room['extra_cost'];
                                                                        }
                                                                    }

                                                                    // Calculate total rate for this room
                                                                    $totalRate = ($rent * $totalDays) + $mattressCost;
                                                                    
                                                        ?>  
                                                                <tr>
                                                                    <td>
                                                                        <?= $i ?>
                                                                    </td>
                                                                    <td>
                                                                        <span><?= $room_no ?></span>
                                                                        <input type="hidden" name="room_ids[]" value="<?= $this->my_encryption->encrypt($rooms[0]['room_id'])?>" >
                                                                    </td>
                                                                    <td>
                                                                        <span><?= $checkInDate->format('d-m-Y') ?></span>
                                                                        <input type="hidden" name="check_in_date[]" value="<?= $checkInDate->format('d-m-Y') ?>" >
                                                                    </td>
                                                                    <td>
                                                                        <span><?= $checkOutDate->format('d-m-Y') ?></span>
                                                                        <input type="hidden" name="check_out_date[]" value="<?= $checkOutDate->format('d-m-Y') ?>" >
                                                                    </td>
                                                                    <td>
                                                                        <span id="total_days_<?= $i ?>"><?= $totalDays ?></span>
                                                                        <input type="hidden" name="total_days[]" value="<?= $totalDays ?>" >
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($mattressCost > 0.00): ?>
                                                                            <input type="text" name="extra_mattres[]"
                                                                                class="form-control input-sm text-right number mattres"
                                                                                value="1" id="extra_mattres_<?= $i ?>">
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($mattressCost > 0.00): ?>
                                                                            <i class="fa fa-inr"></i>
                                                                            &nbsp;<span id="mattres_cost_<?= $i ?>"><?= $rooms[0]['extra_cost'] ?></span>
                                                                            <input type="hidden" name="mattres_amount[]" value="<?= $rooms[0]['extra_cost'] ?>" >
                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if ($rooms[0]['room_type'] == 'AC'): ?>
                                                                            <span
                                                                                id="room_rent_<?= $i ?>"><?= $rooms[0]['ac_rent'] ?></span>
                                                                            (<span><?= $rooms[0]['room_type'] ?> Rate</span>)
                                                                            <input type="hidden" name="room_type[]" value="<?= $rooms[0]['room_type'] ?>" >
                                                                            <input type="hidden" name="room_amount[]" value="<?= $rent ?>" >
                                                                        <?php else: ?>
                                                                            <span
                                                                                id="room_rent_<?= $i ?>"><?= $rooms[0]['nonac_rent'] ?></span>
                                                                            (<span><?= $rooms[0]['room_type'] ?> Rate</span>)
                                                                            <input type="hidden" name="room_type[]" value="<?= $rooms[0]['room_type'] ?>" >
                                                                            <input type="hidden" name="room_amount[]" value="<?= $rent ?>" >
                                                                        <?php endif; ?>

                                                                    </td>
                                                                    <td>
                                                                        <span class="totalRate"
                                                                            id="total_rate_<?= $i ?>"><?= $totalRate ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span>
                                                                            <input type="text"
                                                                                class="form-control input-sm number text-right finalRate"
                                                                                value="<?= $totalRate ?>" id="final_rate_<?= $i ?>">
                                                                        </span>
                                                                    </td>

                                                                    <script>
                                                                        $(function () {
                                                                            $("#extra_mattres_<?= $i ?>").keyup(function () {
                                                                                var extraMattresCount = parseFloat($(this).val()) || 0;
                                                                                var mattresCost = parseFloat($('#mattres_cost_<?= $i ?>').text()) || 0;
                                                                                var roomRent = parseFloat($('#room_rent_<?= $i ?>').text()) || 0;
                                                                                var totalDays = parseFloat($('#total_days_<?= $i ?>').text()) || 0;

                                                                                var totalRoomRate = totalDays * roomRent;
                                                                                var totalMattresCost = (extraMattresCount * mattresCost) * totalDays;
                                                                                var totalAmt = totalRoomRate + totalMattresCost;

                                                                                $('#total_rate_<?= $i ?>').text(totalAmt.toFixed(2));
                                                                                $('#final_rate_<?= $i ?>').val(totalAmt.toFixed(2));
                                                                                $('#taxable_amount_<?= $i ?>').text(totalAmt.toFixed(2));
                                                                            });

                                                                            $("#final_rate_<?= $i ?>").keyup(function () {
                                                                                var finalRate = parseFloat($(this).val()) || 0;
                                                                                var totalRate = parseFloat($('#total_rate_<?= $i ?>').text()) || 0;
                                                                                var difference = finalRate - totalRate;

                                                                                if (difference !== 0) {
                                                                                    if (difference < 0) {
                                                                                        var discountAmount = Math.abs(difference);
                                                                                        $('#discounted_rate_<?= $i ?>').html('Discount: <span class="discount">' + discountAmount + '</span>');
                                                                                    } else {
                                                                                        var additionalAmount = Math.abs(difference);
                                                                                        $('#discounted_rate_<?= $i ?>').html('Added: <span class="additional">' + additionalAmount + '</span>');
                                                                                    }
                                                                                } else {
                                                                                    $('#discounted_rate_<?= $i ?>').html('<span>0</span>');
                                                                                }
                                                                                $('#taxable_amount_<?= $i ?>').text(finalRate.toFixed(2));
                                                                            });
                                                                        });
                                                                        </script>


                                                                    <td class="text-right" id="discounted_rate_<?= $i ?>">
                                                                        <span>0</span>
                                                                    </td>
                                                                    <td class="text-right taxableAmt" id="taxable_amount_<?= $i ?>">
                                                                        <span><?= $totalRate ?></span>
                                                                    </td>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        }

                                                    } ?>
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Total Taxable
                                                            Amount :</td>
                                                        <td class="text-right">
                                                            <span id="total_taxable_amt"></span>
                                                            <input type="hidden" name="booking_id" value="<?=$booking_id?>" >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Total Discount
                                                            Amount :</td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control input-sm number text-right"
                                                                name="discount_amt" id="total_discount" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Total Additional
                                                            Amount :</td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control input-sm number text-right"
                                                                name="added_amt" id="total_additional" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Total GST @12% :</td>
                                                        <td>
                                                            <input type="text" name="gst_amt" id="total_gst"
                                                                class="form-control input-sm number text-right"
                                                                value="0" readonly>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Total Payable
                                                            Amount :</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm number text-right"
                                                                name="total_amt" id="total_payable_amount" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Advance Amount :</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm number text-right" value="<?= isset($paying_amt['PAYING_AMT']) ? $paying_amt['PAYING_AMT'] : '0' ?>" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Paying Amount :
                                                        </td>
                                                        <td>
                                                            <input type="text" name="paying_amount" id="paying_amount" 
                                                                class="form-control input-sm number text-right" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="11" class="text-right">Net Due :
                                                        </td>
                                                        <td>
                                                            <input type="text" id="net_due" class="form-control input-sm number text-right" value="0" disabled>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                <script>
                                                    $(document).ready(function () {
                                                        function calculateTaxableSum() {
                                                            let sum = 0;
                                                            $('.taxableAmt').each(function () {
                                                                let value = parseInt($(this).text()) || 0;
                                                                sum += value;
                                                            });
                                                            $('#total_taxable_amt').text(sum.toFixed(2));
                                                        }

                                                        function calculateDiscountSum() {
                                                            let DiscountSum = 0;
                                                            $('.discount').each(function () {
                                                                let value = parseInt($(this).text()) || 0;
                                                                DiscountSum += value;
                                                            });
                                                            $('#total_discount').val(DiscountSum.toFixed(2));
                                                        }

                                                        function calculateAdditionalSum() {
                                                            let AdditionalSum = 0;
                                                            $('.additional').each(function () {
                                                                let value = parseInt($(this).text()) || 0;
                                                                AdditionalSum += value;
                                                            });
                                                            $('#total_additional').val(AdditionalSum.toFixed(2));
                                                        }

                                                        function calculateGST() {
                                                            let total_taxable_amt = parseInt($('#total_taxable_amt').text()) || 0;
                                                            let gst = (total_taxable_amt * 12) / 100;
                                                            let total_payable_amount = total_taxable_amt + gst;

                                                            // Update the GST and payable amount in the respective fields
                                                            $('#total_gst').val(gst.toFixed(2));
                                                            $('#total_payable_amount').val(total_payable_amount.toFixed(2));
                                                            $('#net_amount').html(total_payable_amount.toFixed(2));
                                                        }


                                                        calculateTaxableSum();
                                                        calculateDiscountSum();
                                                        calculateAdditionalSum();
                                                        calculateGST();


                                                        $(".finalRate, .mattres").keyup(function () {
                                                            calculateTaxableSum();
                                                            calculateDiscountSum();
                                                            calculateAdditionalSum();
                                                            calculateGST();
                                                        });
                                                    });
                                                </script>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div id="ContentPlaceHolder1_dvPaymentS" class="box-footer">
                    <div class="row">
                        <div class="col-md-1">
                        <a class="btn btn-sm btn-danger " href="<?= base_url("hotel-room-booking"); ?>">
                            <i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                        </div>
                        <div class="col-md-9">
                            <?php
                            if($current_checkin == 'CHECKIN'){
                            ?>

                            <span style="margin-right: 10px;"><b>Check In :</b></span>
                            <label style="margin-right: 20px;">
                                <input type="radio" name="todaycheck" value="YES" checked style="width: 20px; height: 20px; margin-right: 5px; border-radius: 5px;"> Yes
                            </label>
                            
                            <label>
                                <input type="radio" name="todaycheck" value="NO" <?=date('d-m-Y')?'disabled':''?> style="width: 20px; height: 20px; margin-right: 5px; border-radius: 5px;"> No
                            </label>

                            <?php
                            } else { }
                            ?>
                        </div>

                        <div class="col-md-2">
                            <a class="btn btn-sm btn-success pull-right" id="proceedBtn">
                                <i class="fa fa-inr"></i> Proceed to Payment</a>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade in" id="paymentModeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <h4 class="modal-title">Payment Mode</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Net Amount : <i class="fa fa-inr"></i> <span id="net_amount"></span></label><br>
                        <label>Paying Amount : <i class="fa fa-inr"></i> <span id="pay_amount">0</span></label>
                    </div>
                </div>
                <hr style="margin: 5px 0px;">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Payment Mode</label>
                            <select class="form-control input-sm" id="payment_mode">
                                <option value = "">Select</option>
                                <?php
                                    foreach ($payment_data as $payment_mode) {
                                    ?>
                                        <option value = "<?=$this->my_encryption->encrypt($payment_mode['LEDGER_CODE'])?>" data-count="<?=$payment_mode['ENTRY_NEEDED']?>">
                                            <?=$payment_mode['DESCRIPTION']?>
                                        </option>;
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Payment Amount</label>
                            <input class="form-control input-sm number text-right" id="payment_amount">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <br>
                            <button type="button" class="btn btn-success btn-sm" id="addBtn"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row element"></div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-condensed table-bordered table-hover" id="paymentTable">
                            <thead>
                            <tr class="bg-info">
                                <th>Payment Mode</th>
                                <th>Payment Amount</th>
                                <th>Payment Details</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-info btn-sm reset" ><i class="fa fa-recycle"></i>&nbsp;Reset</button>
                        <button type="submit" class="btn btn-success btn-sm" id="save-btn"><i class="fa fa-inr"></i>&nbsp;Pay Now</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>
<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
        
        $('#proceedBtn').click(function() {
            /*let total_payable_amount = parseFloat($('#total_payable_amount').val());
            let paying_amount = parseFloat($('#paying_amount').val());
            if (!paying_amount || paying_amount === 0) {
                $.toast({
                    heading: "Warning",
                    text: 'Paying amount should not be zero',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            } else if (paying_amount > total_payable_amount) {
                $.toast({
                    heading: "Warning",
                    text: 'Paying amount should be less than or equal to total payable amount',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            } else  {
                $('#paymentModeModal').modal('show');
            }*/
            $('#paymentModeModal').modal('show');
        });

        /* $('#payment_details_form').submit(function() {
            var tr_length = $('#paymentTable tbody tr').length;
            var pay_amount = parseFloat($('#pay_amount').text());

            if (tr_length > 0 && pay_amount === 0) {
                return true;
            } else {
                $.toast({
                    heading: "Warning",
                    text: tr_length === 0 ? 
                        'Select payment mode, enter amount, and click the plus button to proceed' : 
                        'Payment amount must be zero to proceed',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000 
                });
                return false;
            }
        }); */



        $('#paying_amount').keyup(function () {
            var paying_amount = parseFloat($('#paying_amount').val()) || 0;
            var total_payable_amount = parseFloat($('#total_payable_amount').val()) || 0;

            var net_due = total_payable_amount - paying_amount;
            
            $('#net_due').val(net_due.toFixed(2));
            $('#pay_amount').text(paying_amount.toFixed(2));
            $('#payment_amount').val(paying_amount.toFixed(2));
        });

        $('#payment_mode').change(function () {
            let inputElement = $(this).find(':selected').data('count');

            var splitElements = inputElement.split(',');
            $('.element').html('');
            if (splitElements.length > 0 && splitElements[0] !== "") {
                var inputField = '';
                splitElements.forEach(function(element, index) {
                    inputField += '<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '<input type="text" class="form-control input-sm number" id="index' + index + '" name="pay_item[]" placeholder="' + element + '" data-name="' + element + '">' +
                        '</div>' +
                    '</div>';
                });
            }
            $('.element').html(inputField);
        });

        $('#addBtn').click(function () {
            let selectedText = $('#payment_mode option:selected').text().trim();
            let paymentMode = $('#payment_mode').val();
            let paymentAmount = $('#payment_amount').val();
            let pay_amount = parseFloat($('#pay_amount').text()); // Ensure it's a number

            var paymentDetails = $("input[name='pay_item[]']").map(function() {
                let itemName = $(this).data('name');
                let itemValue = $(this).val();
                if (itemValue === '') {
                    $.toast({
                        heading: "Warning",
                        text: 'Please enter all fields',
                        showHideTransition: "fade",
                        position: "top-right",
                        icon: "error",
                        loader: true,
                        timeout: 30000
                    });
                    throw "Validation Error";
                }
                return itemName + ': ' + itemValue;
            }).get().join(',');

            if (paymentMode === '') {
                $.toast({
                    heading: "Warning",
                    text: 'Please select payment mode',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            } else if (paymentAmount === '') {
                $.toast({
                    heading: "Warning",
                    text: 'Please enter payment amount',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            } else {
                paymentAmount = parseFloat(paymentAmount);
                
                if (paymentAmount <= pay_amount) {
                    let paying_amt = pay_amount - paymentAmount;
                    $('#pay_amount').text(paying_amt.toFixed(2));
                    let str = '<tr>' +
                                    '<td>' + selectedText + '</td>' +
                                    '<input type="hidden" id="payMode" value="'+selectedText+'">' +
                                    '<input type="hidden" name="payment_mode[]" id="paymode_val" value="'+paymentMode+'">' +
                                    '<td class="text-right">' + paymentAmount + '</td>' +
                                    '<input type="hidden" name="payment_amount[]" value="'+paymentAmount+'">' +
                                    '<td>' + paymentDetails.replaceAll(',', '<br>') + '</td>' +
                                    '<input type="hidden" value="' + paymentDetails + '">' +
                                    '<td><button type="button" class="btn btn-danger btn-sm remove-row" data-amount="'+paymentAmount+'"><i class="fa fa-times"></i></button></td>' +
                                '</tr>';
                    $('#paymentTable tbody').append(str);
                    $('.element').html('');
                    $('#payment_mode option:selected').hide();
                    $('#payment_mode').val('');
                    $('#payment_amount').val('');
                    
                } else {
                    $.toast({
                        heading: "Warning",
                        text: 'Invalid payment amount',
                        showHideTransition: "fade",
                        position: "top-right",
                        icon: "error",
                        loader: true,
                        timeout: 30000
                    });
                }
            }
        });


        $(document).on('click', '.remove-row', function () {
            if (confirm("Are you sure you want to delete this attachment?")) {
                var paymode_val = $('#paymode_val').val();
                var payMode = $('#payMode').val();
                var pay_amount = $('#pay_amount').text();
                var amount = $(this).data('amount');
                var paying_amt = parseFloat(pay_amount) + amount;
                $('#pay_amount').text(paying_amt.toFixed(2));
                $('#payment_mode option[value="' + paymode_val + '"]').show()
                $(this).closest('tr').remove();
            }
        });



        $('.reset').click(function () {
            $('#payment_mode option').show();
            $('#paymentTable tbody').empty();
            $('#payment_amount').val('');
            var paying_amount = $('#paying_amount').val();
            $('#pay_amount').text(parseFloat(paying_amount).toFixed(2));
        });

        

    });
</script>