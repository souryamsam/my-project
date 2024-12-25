<?php
if (isset($_POST["plan_value"]) && $_POST["plan_value"] == 'plan_search_value') {
    $date = $_POST['date'];
} else {
    $date = $this->my_encryption->decrypt($this->uri->segment(3));
}
$slug = $this->my_encryption->decrypt($this->uri->segment(2));
if ($slug === 'CHECK_IN') {
    $url = 'planned-check-in/';
} else if ($slug === 'CHECK_OUT') {
    $url = 'planned-check-out/';
} else {
    $url = 'planned-stay-period/';
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <?= form_open(base_url($url . $this->my_encryption->encrypt('CHECK_IN') . '/' . $this->my_encryption->encrypt($date))); ?>
                    <input type="hidden" name="plan_value" value="plan_search_value">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control input-sm datepicker"
                                value="<?= $date ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="display:block;">&nbsp;</label>
                            <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top"
                                data-original-title="Click to Search">
                                <span><i class="fa fa-search"></i></span>
                            </button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="box-body">
                <h4 style="margin-top: 0px;">Planned Check In Details for <?= $date; ?></h4>
                <hr style="border-color: rgb(189, 178, 178);margin-top: 5px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-bordered" id="planned_checkin_tbl">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Customer Details</th>
                                        <th style="width:80px">Contact No.</th>
                                        <th>Address</th>
                                        <th>Check In Rooms</th>
                                        <th>No. of Days Planned for Stay</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($planned_checkin_data)) {
                                        foreach ($planned_checkin_data as $key => $data) {
                                            ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $data['GUEST_NAME'] ?></td>
                                                <td><i class="fa fa-phone text-primary"></i>&nbsp;<?= $data['CONTACT_NO'] ?>
                                                </td>
                                                <td><i class="fa fa-map-marker text-warning" aria-hidden="true"></i>&nbsp;
                                                    <?= $data['ADDRESS'] ?>
                                                </td>
                                                <td><i class="fa fa-home text-primary" aria-hidden="true"></i>&nbsp;
                                                    <?= $data['ROOM_NO'] ?>
                                                </td>
                                                <td class="text-center"><b><?= $data['NO_DAYS'] ?></b></td>
                                                <td>
                                                    <?php
                                                    if ($data['CHECKED_IN'] == 'NO') {
                                                        ?>
                                                        <label class=" label label-danger" style="display:inline-block;"><i
                                                                class="fa fa-unlock"></i>&nbsp;Not Checked IN</label>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <label class="label label-success" style="display:inline-block;"><i
                                                                class="fa fa-lock"></i>&nbsp;Checked In |
                                                            <?= date('h:i a', strtotime($data['CHECKED_IN_TIME'])) ?></label>

                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if (date('d-m-Y')) {
                                                        ?>
                                                        <span><i class="fa fa-lock"></i></span>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button class=" btn btn-xs btn-primary" type="button"
                                                            onclick="initiate_checkin('<?= $data['GUEST_NAME'] ?>','<?= $this->my_encryption->encrypt($data['CUSTOMER_ID']) ?>','<?= $this->my_encryption->encrypt($data['BOOKING_ID']) ?>')"
                                                            style="display:inline-block;"><i class="fa fa-lock"></i>&nbsp;Initiate
                                                            Check In</button>

                                                        <?php
                                                    }
                                                    ?>
                                                </td>
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
            </div>

        </div>
    </div>
</div>



<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
        $('#planned_checkin_tbl').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
    });

    function initiate_checkin(guest_name, guest_id, booking_id) {
        $('#custom_id').val(booking_id);
        $("#custom_form").append('<input type="hidden" name="guest_name" value="' + guest_name + '" >');
        $("#custom_form").append('<input type="hidden" name="guest_id" value="' + guest_id + '" >');
        $('#mode').val('edit_booking_details');
        $('#custom_form').attr('action', "<?= base_url('edit-room-booking') ?>");
        $('#custom_form').submit();
    }
</script>