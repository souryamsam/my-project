<?php
if (isset($_POST["hotel_dashboard"]) && $_POST["hotel_dashboard"] == 'hotel_dashboard_search_flag') {
    $date = $_POST['search_date'];
} else {
    $date = date('d-m-Y');
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <?= form_open(base_url('hotel-dashboard')) ?>
                    <input type="hidden" name="hotel_dashboard" value="hotel_dashboard_search_flag">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" class="form-control input-sm datepicker" name="search_date"
                                value="<?= $date; ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="display:block;">&nbsp;</label>
                            <button type="submit" class="btn btn-info btn-sm" title="Click to search">
                                <span><i class="fa fa-search"></i></span>
                            </button>
                            <!-- <a href="<?= base_url('planned-stay-period/' . $this->my_encryption->encrypt('ALL')) ?>"
                                class="btn btn-info btn-sm">View All</a> -->
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $hotel_dashboard_count['VACANT_ROOM'] ?></h3>
                <p>Vacant Rooms (<span><?= $date ?></span>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-home"></i>
            </div>
            <a href="<?= base_url('room-vacancy-details/' . $this->my_encryption->encrypt($date)); ?>"
                class="small-box-footer box-more">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $hotel_dashboard_count['TODAY_PLANNED_CHECK_IN'] ?></h3>
                <p>Planned Check In (<span><?= $date ?></span>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-handshake-o"></i>
            </div>
            <a href="<?= base_url('planned-check-in/' . $this->my_encryption->encrypt('CHECK_IN') . '/' . $this->my_encryption->encrypt($date)) ?>"
                class="small-box-footer box-more">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-red">
            <div class="inner">
                <h3><?= $hotel_dashboard_count['TODAY_PLANNED_CHECK_OUT'] ?></h3>
                <p>Planned Check Out (<span><?= $date ?></span>)</p>
            </div>
            <div class="icon">
                <i class="fa fa-motorcycle"></i>
            </div>
            <a href="<?= base_url('planned-check-out/' . $this->my_encryption->encrypt('CHECK_OUT') . '/' . $this->my_encryption->encrypt($date)) ?>"
                class="small-box-footer box-more">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $hotel_dashboard_count['CURRENT_GUEST'] ?></h3>
                <p>Current Guest</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?= base_url('current-guest'); ?>" class="small-box-footer box-more">More info <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Today Checked In Customers</h3>
                <div class="box-tools pull-right">

                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover" id="hotel_dashboard_tbl">
                        <thead class="bg-info">
                            <tr>
                                <th>Sl. No</th>
                                <th>Customer Name</th>
                                <th style="width:90px">Contact No</th>
                                <th>Room No</th>
                                <th>Planned Check in Date</th>
                                <th>Planned Check Out Date</th>
                                <th>Actual Check In Date & Time</th>
                                <th>Actual Check Out Date</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($dashboard_customer_data)) {
                                foreach ($dashboard_customer_data as $key => $customer_data) {
                                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $customer_data['GUEST_NAME'] ?></td>
                                        <td><i class="fa fa-phone text-info"></i>&nbsp; <?= $customer_data['CONTACT_NO'] ?></td>
                                        <td><i class="fa fa-home text-primary"></i><?= $customer_data['ROOM_NO'] ?></td>
                                        <td><i class="fa fa-calendar text-success"></i>
                                            <?= $customer_data['CHECK_IN_DATE'] != '' ? date('d/m/Y', strtotime($customer_data['CHECK_IN_DATE'])) : '' ?>
                                        </td>
                                        <td><i class="fa fa-calendar text-danger"></i>
                                            <?= $customer_data['PLANNED_CHECK_OUT_DATE'] != '' ? date('d/m/Y', strtotime($customer_data['PLANNED_CHECK_OUT_DATE'])) : '' ?>
                                        </td>
                                        <td><i class="fa fa-calendar text-success"></i>
                                            <?= $customer_data['ACTUAL_CHECK_IN_DATETIME'] != '' ? date('d/m/Y | h:i a', strtotime($customer_data['ACTUAL_CHECK_IN_DATETIME'])) : '' ?>
                                        </td>
                                        <td><i class="fa fa-calendar text-danger"></i>
                                            <?= $customer_data['ACTUAL_CHECK_OUT_DATETIME'] != '' ? date('d/m/Y', strtotime($customer_data['ACTUAL_CHECK_OUT_DATETIME'])) : '' ?>
                                        </td>
                                        <td><i class="fa fa-map-marker text-warning"></i>
                                            <?= $customer_data['ADDRESS'] ?></td>
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

<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
        $('#hotel_dashboard_tbl').DataTable();
    });
</script>