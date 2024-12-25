<?php
$selected_room = $this->session->userdata('selected_room');
if (isset($_POST["customer_search"]) && $_POST["customer_search"] == 'search_cutomers_details') {
    $document_id_no = isset($_POST['document_id_no']) ? $_POST['document_id_no'] : '';
    $document_type = isset($_POST['document_type']) ? $_POST['document_type'] : '';
} else {
    $document_id_no = '';
    $document_type = '';
}
?>
<section class="content">
    <div class="row">
        <?php
        if ($selected_room) {
            ?>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h4 class="box-title" style="width: 100%;"><i class="fa fa-shopping-cart"></i> Summary</h4>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <?php
                                                $overallTotalRate = 0.00;                                            
                                                
                                                if (!empty($selected_room)) {
                                                    // Group data by room_no and room_type
                                                    $groupedRooms = [];
                                                    foreach ($selected_room as $room) {
                                                        $groupedRooms[$room['room_no']][$room['room_type']][] = $room;
                                                    }
                                                    foreach ($groupedRooms as $room_no => $roomTypes) {
                                                        foreach ($roomTypes as $room_type => $rooms) {                                                          

                                                            // Dates for first check-in and last check-out
                                                            $checkInDate = new DateTime($rooms[0]['room_date']);
                                                            $checkOutDate = new DateTime(end($rooms)['room_date']);

                                                            // Set rent based on room type
                                                            $rent = ($room_type == 'AC') ? $rooms[0]['ac_rent'] : $rooms[0]['nonac_rent'];

                                                            // Calculate mattress cost in a single loop
                                                            $totalDays = 0;
                                                            $mattres_count = 0;
                                                            $mattressCost = 0.00;

                                                            foreach ($rooms as $room) {
                                                                if ($room['room_type'] == 'AC') {
                                                                    $totalDays ++;
                                                                }else{
                                                                    $totalDays ++;
                                                                }

                                                                if ($room['mattres'] == 'YES') {
                                                                    $mattressCost = $room['extra_cost'];
                                                                    $mattres_count ++;
                                                                }
                                                            }

                                                            // Calculate total rate for thisroom
                                                            $roomAmount = $rent * $totalDays;
                                                            $mattressAmount = $mattressCost * $mattres_count;
                                                            $totalRate = $roomAmount + $mattressAmount;
                                                            $overallTotalRate += $totalRate;
                                                            ?>
                                                                <tr>
                                                                    <td colspan="2" class="bg-primary">
                                                                        <h5><b>Check-In : <?= $checkInDate->format('d/m/Y') ?> | Check-Out :<?= $checkOutDate->format('d/m/Y') ?></b></h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <table class="table table-bordered" style="margin-bottom: 0px;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4">
                                                                                        <p style="margin: 0px;">
                                                                                            <span style="font-weight: 600;"><i class="fa fa-hashtag"></i> Room No :</span> <?= $room_no ?>
                                                                                        </p>
                                                                                        <p style="margin: 0px;">
                                                                                            <span style="font-weight: 600;"><i class="fa fa-home"></i> Room Category :</span> <?= $rooms[0]['room_category'] ?>
                                                                                        </p>
                                                                                        <p style="margin: 0px;">
                                                                                            <span style="font-weight: 600;"> <i class="fa fa-bed"></i> Bed Type :</span> <?= $rooms[0]['bed_type'] ?>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="bg-info">
                                                                                    <td></td>
                                                                                    <td style="font-weight: 600;">Rate</td>
                                                                                    <td style="font-weight: 600;">Day/Quantity
                                                                                    </td>
                                                                                    <td style="font-weight: 600;">Amount</td>
                                                                                </tr>
                                                                                <?php if ($room_type == 'AC'){ ?>
                                                                                <tr>
                                                                                    <td><i class="fa fa-snowflake-o"></i> AC</td>
                                                                                    <td class="text-right"><?= $rent ?></td>
                                                                                    <td class="text-right"><?= $totalDays ?></td>
                                                                                    <td class="text-right"><?=number_format($roomAmount,2)?></td>
                                                                                </tr>
                                                                                <?php } else { ?>
                                                                                <tr>
                                                                                    <td><i class="fa fa-sun-o"></i> Non-AC</td>
                                                                                    <td class="text-right"><?= $rent ?></td>
                                                                                    <td class="text-right"><?= $totalDays ?></td>
                                                                                    <td class="text-right"><?=number_format($roomAmount,2)?></td>
                                                                                </tr>
                                                                                <?php } if ($mattressCost > 0.00){ ?>
                                                                                <tr>
                                                                                    <td><i class="fa fa-bed"></i> Extra-Mattress</td>
                                                                                    <td class="text-right"><?= $mattressCost ?></td>
                                                                                    <td class="text-right"><?=$mattres_count?></td>
                                                                                    <td class="text-right"><?=number_format($mattressAmount,2)?></td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                                <tr class="bg-warning">
                                                                                    <td colspan="2"><b>Estimated Amount</b></td>
                                                                                    <td colspan="2" class="text-right"><?= number_format($totalRate,2)?></td>
                                                                                </tr>

                                                                                
                                                                            </tbody>

                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                            <tfoot>

                                                <tr>
                                                    <td>
                                                        <b>Total Estimated Amount:</b>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <i class="fa fa-inr"></i>
                                                        <span id="total_rate"><?= number_format($overallTotalRate, 2) ?></span>
                                                    </td>
                                                </tr>


                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-8">
            <div class="box box-primary" id="customer-segment">
                <div class="box-header with-border">
                    <h3 class="box-title">Customer Segment</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12" style="display:block">
                        <div class="row">
                            <div class="form-group">
                                <div class="row">
                                    <form action="<?= base_url("room-booking") ?>" method="post">
                                        <input type="hidden" name="customer_search" value="search_cutomers_details">
                                        <div class="col-md-3">
                                            <select class="form-control input-sm select2" id="customerinputselect"
                                                name="document_type" required>
                                                <option value="">Select</option>
                                                <?php
                                                if (!empty($document_type_data)) {
                                                    foreach ($document_type_data as $document) {
                                                        ?>
                                                        <option
                                                            value="<?= $this->my_encryption->encrypt($document['RECORD_ID']) ?>"
                                                            <?= $document_type == $this->my_encryption->encrypt($document['RECORD_ID']) ? 'selected' : '' ?>>
                                                            <?= $document['RECORD_NAME'] ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5" id="numberinput">
                                            <input type="text" class="form-control input-sm" name="document_id_no"
                                                value="<?= $document_id_no ?>" placeholder="Enter Here..." required>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa fa-search"></i>&nbsp; &nbsp; Search</button>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            OR
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-sm btn-danger float-right" id="newbtn"
                                                href="<?= base_url("customer-master") ?>"><i
                                                    class="fa fa-user"></i>&nbsp;
                                                &nbsp; New ?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST["customer_search"]) && $_POST["customer_search"] === 'search_cutomers_details') {
                                ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Customer Name</th>
                                                        <th>Contact No</th>
                                                        <th>Email Address</th>
                                                        <th>City</th>
                                                        <th>Date of Registration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($customer_search_data)) {
                                                        foreach ($customer_search_data as $key => $customer) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="radio" name="customerinfo" id="radio<?= $key ?>">
                                                                    <input type="hidden" id="guestId<?= $key ?>"
                                                                        value="<?= $this->my_encryption->encrypt($customer['GUEST_ID']) ?>">
                                                                </td>
                                                                <td><i class="fa fa-user text-success"></i>
                                                                    &nbsp;<span
                                                                        id="guestName<?= $key ?>"><?= $customer['GUEST_NAME'] ?></span>
                                                                </td>
                                                                <td><i class="fa fa-phone text-primary"></i>
                                                                    &nbsp;<span
                                                                        id="guestContactNo<?= $key ?>"><?= $customer['CONTACT_NO'] ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php if($customer['EMAIL_ADDRESS']!=""){ ?>
                                                                    <i class="fa fa-envelope text-warning"></i>
                                                                    &nbsp;<span
                                                                        id="guestEmailId<?= $key ?>"><?= $customer['EMAIL_ADDRESS'] ?></span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td><?= $customer['CITY_NAME'] ?></td>
                                                                <input type="hidden" id="guestAddress<?= $key ?>"
                                                                    value="<?= $customer['CITY_NAME'] . ', ' . $customer['ADDRESS_1'] . ', ' . $customer['ADDRESS_2'] ?>">
                                                                <td><i class="fa fa-calendar text-red"></i>
                                                                    &nbsp;<?= date("d/m/Y", strtotime($customer['CREATION_DATE'])) ?>
                                                                </td>
                                                                <th>
                                                                    <!-- <a href="javascript:void(0)" class="btn btn-info btn-sm"
                                                                        id="customer_info"
                                                                        onclick="editMode('<?= $this->my_encryption->encrypt($customer['GUEST_ID']) ?>')">
                                                                        <i class="fa fa-info"></i>
                                                                    </a> -->
                                                                    <a href="<?= base_url('customer-master/' . $this->my_encryption->encrypt($customer['GUEST_ID'])) ?>"
                                                                        class="btn btn-info btn-sm" id="customer_info<?= $key ?>"
                                                                        style="display:none">
                                                                        <i class="fa fa-info"></i>
                                                                    </a>

                                                                    </a>
                                                                </th>
                                                            </tr>
                                                            <form id="bookingForm<?= $key ?>" method="post"
                                                                action="<?= base_url('payment-info') ?>">
                                                                <input type="hidden" name="custom_id" id="c_id<?= $key ?>">
                                                                <input type="hidden" name="c_name" id="c_name<?= $key ?>">
                                                                <input type="hidden" name="c_email" id="c_email<?= $key ?>">
                                                                <input type="hidden" name="c_contactNo" id="c_contactNo<?= $key ?>">
                                                                <input type="hidden" name="c_address" id="c_address<?= $key ?>">
                                                            </form>

                                                            <script>
                                                                $(function () {
                                                                    $('input[name="customerinfo"]').click(function () {
                                                                        var guestId = $('#guestId<?= $key ?>').val();
                                                                        var guestName = $('#guestName<?= $key ?>').text();
                                                                        var guestContactNo = $('#guestContactNo<?= $key ?>').text();
                                                                        var guestEmailId = $('#guestEmailId<?= $key ?>').text();
                                                                        var guestAddress = $('#guestAddress<?= $key ?>').val();
                                                                        if ($(this).is(':checked')) {
                                                                            $('#proceed_btn').show();
                                                                            $('#customer_info<?= $key ?>').show();

                                                                            $('#c_id<?= $key ?>').val(guestId);
                                                                            $('#c_name<?= $key ?>').val(guestName);
                                                                            $('#c_email<?= $key ?>').val(guestEmailId);
                                                                            $('#c_contactNo<?= $key ?>').val(guestContactNo);
                                                                            $('#c_address<?= $key ?>').val(guestAddress);
                                                                        } else {
                                                                            $('#proceed_btn').hide();
                                                                            $('#customer_info<?= $key ?>').hide();

                                                                            $('#c_id<?= $key ?>').val('');
                                                                            $('#c_name<?= $key ?>').val('');
                                                                            $('#c_email<?= $key ?>').val('');
                                                                            $('#c_contactNo<?= $key ?>').val('');
                                                                            $('#c_address<?= $key ?>').val('');
                                                                        }
                                                                    });
                                                                    $('#proceed_btn').click(function () {
                                                                        $('#bookingForm<?= $key ?>').submit();
                                                                    });
                                                                });
                                                            </script>
                                                            <?php
                                                        }
                                                    } else {
                                                        if (isset($_POST["customer_search"]) && $_POST["customer_search"] == 'search_cutomers_details') {
                                                            ?>
                                                            <tr>
                                                                <td colspan="7" class="text-center text-danger"><b>No records
                                                                        found.</b></td>
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
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success pull-right" id="proceed_btn"
                        style="display:none">
                        <i class="fa fa-inr"></i> Proceed to Payment
                    </button>

                    <a class="btn btn-sm btn-danger " href="<?= base_url("hotel-room-booking") ?>">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    });
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_customer_details';
        document.getElementById('custom_form').action = "<?= base_url('customer-master') ?>";
        document.getElementById('custom_form').submit();
    }
</script>