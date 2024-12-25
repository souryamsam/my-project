<?php
if (isset($_POST["register_search"]) && $_POST["register_search"] == 'booking_register_search') {
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : '';
    $guest_name = isset($_POST['guest_name']) ? $_POST['guest_name'] : '';
    $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';
    $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';
} else {
    $search = '';
    $contact_no = '';
    $guest_name = '';
    $from_date = '';
    $to_date = '';
}
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <?= form_open(base_url('hotel-room-booking-register')); ?>
                    <input type="hidden" name="register_search" value="booking_register_search">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Search</label>
                                <select class="div-toggle form-control input-sm select2" name="search">
                                    <option value="DATE"<?= ($search == 'DATE') ? 'selected' : '' ?>>DATE</option>
                                    <option value="CONTACT_NO"<?= ($search == 'CONTACT_NO') ? 'selected' : '' ?>>CONTACT NO</option>
                                    <option value="GUEST_NAME"<?= ($search == 'GUEST_NAME') ? 'selected' : '' ?>>GUEST NAME</option>
                                    <option value="VACANT_ROOMS"<?= ($search == 'VACANT_ROOMS') ? 'selected' : '' ?>>VACANT ROOMS</option>
                                    <option value="BOOKED_ROOMS"<?= ($search == 'BOOKED_ROOMS') ? 'selected' : '' ?>>BOOKED ROOMS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-lg-8 hide2">
                                    <div class="contact" style="display: <?= ($search == 'CONTACT_NO') ? 'block' : 'none' ?>;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label style="display:block;">&nbsp;</label>
                                                    <input type="text" class="form-control input-sm number"
                                                        placeholder="" value="<?= $contact_no?>" name="contact_no" id="contact_no">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="guest" style="display: <?= ($search == 'GUEST_NAME') ? 'block' : 'none' ?>;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label style="display:block;">&nbsp;</label>
                                                    <input type="text" class="form-control input-sm" placeholder=""
                                                        value="<?= $guest_name?>"name="guest_name" id="guest_name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Date" style="display: <?= (!empty($contact_no) || !empty($guest_name)) && (empty($from_date) && empty($to_date)) ? 'none' : 'block' ?>;">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>From Date</label>
                                                    <input type="text" class="form-control input-sm datepicker"
                                                        placeholder="<?= date('d-m-Y') ?>" name="from_date" id="form_date" value="<?= $from_date?>"
                                                        id="from_date">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <input type="text" class="form-control input-sm datepicker"
                                                        placeholder="<?= date('d-m-Y') ?>" name="to_date" id="to_date" value="<?=$to_date?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label style="display:block;">&nbsp;</label>
                                        <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                            data-placement="top" data-original-title="Click to Search">
                                            <span><i class="fa fa-search"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="booking_register_table">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Customer Name</th>
                                        <!-- <th>Contact No</th> -->
                                        <!-- <th>Guests</th> -->
                                        <th>Booking Date</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Agent Name</th>
                                        <th>Booking Status</th>
                                        <th>Booking Details</th>
                                        <th>Booking Receipt</th>
                                        <th>Lock Booking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($search_results[0])) {
                                        $i = 1;
                                        foreach ($search_results[0] as $result) { ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><a href="#" data-toggle="modal" data-target="#user-info"
                                                        data-guest-name="<?= $result['GUEST_NAME']; ?>"
                                                        data-contact-no="<?= $result['CONTACT_NO']; ?>"
                                                        data-dob="<?= date('d-m-Y', strtotime($result['DOB'])); ?>"
                                                        data-email="<?= $result['EMAIL_ADDRESS']; ?>" data-address="<?= $result['ADDRESS_1']; ?>">
                                                        <?= $result['CUSTOMER_NAME']; ?></a><br><i class="fa fa-phone">&nbsp;<?= $result['CONTACT_NO']; ?></i>
                                                </td>
                                                <!-- <td><a href="#" data-toggle="modal" data-target="#example-modal2"><i
                                                            class="fa fa-user text-warning"></i>
                                                        &nbsp;10</a></td> -->
                                                <td><?= date('d-m-Y', strtotime($result['BOOKING_DATE'])); ?></td>
                                                <td>
                                                    <span><?= date('d-m-Y', strtotime($result['CHECK_IN_DATE'])); ?></span>
                                                </td>
                                                <td>
                                                    <span><?= date('d-m-Y', strtotime($result['CHECK_OUT_DATE'])); ?></span>
                                                </td>
                                                <td>
                                                    <span><?= $result['AGENT_NAME']; ?></span>
                                                </td>
                                                <td>
                                                    <span><label
                                                            class="label label-success"><?= $result['BOOKING_STATUS']; ?></label></span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-info"
                                                        href="<?= base_url('booking-details-view/' . $this->my_encryption->encrypt($result['BOOKING_ID'])); ?>"><i
                                                            class="fa fa-search"></i>&nbsp;View</a>
                                                </td>

                                                <td>
                                                    <a class="btn btn-sm  btn-primary" data-toggle="modal"
                                                        data-target="#example-modal"><i
                                                            class="fa fa-money"></i>&nbsp;Receipt</a>
                                                </td>
                                                <td>
                                                    <?php if($result['LOCK_BOOKING']==="CHECKED_ID"){ ?>
                                                        <span><label class="label label-success"><i
                                                                class="fa fa-unlock"></i>&nbsp;Check In</label></span>
                                                    <?php }elseif($result['LOCK_BOOKING'] === "CHECKED_OUT"){ ?>
                                                        <span><label class="label label-danger"><i
                                                                class="fa fa-lock"></i>&nbsp;Check Out</label></span>
                                                    <?php }else{ ?>
                                                            
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
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
</section>
<?= $this->load->view($booking_receipt_modal); ?>
<script>
    $(document).ready(function () {
            $('.table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [5, 10, 25, 50, 100], 
                pageLength: 10  
            });
        });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
    $(".number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    $(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });
    })
    $(".div-toggle").on("change", function () {
        var selected = $(this).val();
        if (selected === "DATE") {
            $(".Date").show();
            $(".hide2").show();
            $(".contact").hide();
            $(".guest").hide();
            $("#form_date").val('');
            $("#to_date").val('');
        }
        else if (selected === "CONTACT_NO") {
            $(".Date").hide();
            $(".hide2").show();
            $(".contact").show();
            $(".guest").hide();
            $("#contact_no").val('');
            $("#guest_name").val('');
            $("#form_date").val('');
            $("#to_date").val('');
        }
        else if (selected === "GUEST_NAME") {
            $(".Date").hide();
            $(".hide2").show();
            $(".contact").hide();
            $(".guest").show();
            $("#guest_name").val('');
            $("#contact_no").val('');
        }
        else {
            $(".hide2").hide();
        }
    })
    $('#user-info').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var guestName = button.data('guest-name');
        var contactNo = button.data('contact-no');
        var dob = button.data('dob');
        var email = button.data('email');
        var address = button.data('address');

        var modal = $(this);
        modal.find('#modal-guest-name').text(guestName);
        modal.find('#modal-contact-no').text(contactNo);
        modal.find('#modal-dob').text(dob);
        modal.find('#modal-email').text(email);
        modal.find('#modal-address').text(address);
    });
</script>