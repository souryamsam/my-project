<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list"></i>&nbsp;Booking Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="all_checkbox"></th>
                                        <th>Sl.No.</th>
                                        <th>Occupied Date</th>
                                        <th>Room No</th>
                                        <th>Room Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($booking_details)) {
                                        $i = 1;
                                        foreach ($booking_details as $booking) { ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkbox_class"></td>
                                                <td><?= $i; ?></td>
                                                <td>
                                                    <span>12/06/2024</span>
                                                </td>
                                                <td>
                                                    <span><?= $booking['ROOM_NO']; ?></span>
                                                    (<?= $booking['ROOM_TYPE']; ?>)
                                                </td>
                                                <td>
                                                    <span><?= $booking['BED_TYPE']; ?></span>
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
                <div class="box-footer">
                    <a class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#example-modal"><i
                            class="fa fa-times"></i>
                        &nbsp;Cancel Booking</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->load->view($booking_details_view_modal); ?>
<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
    $('#all_checkbox').on('click', function () {
        $('.checkbox_class').prop('checked', $(this).prop('checked'));
    });
</script>