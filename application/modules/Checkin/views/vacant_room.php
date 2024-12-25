<?php
if (isset($_POST["room_vacancy"]) && $_POST["room_vacancy"] == 'room_vacancysearch_value') {
    $date = $_POST['date'];
} else {
    $date = $this->my_encryption->decrypt($this->uri->segment(2));
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <?= form_open(base_url('room-vacancy-details')); ?>
                    <input type="hidden" name="room_vacancy" value="room_vacancysearch_value">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="date" id="v_date" class="form-control input-sm"
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
                <h4 style="margin-top: 0px;">Room Vacancy Report for <?= $date ?></h4>
                <hr style="border-color: rgb(189, 178, 178);margin-top: 5px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered" id="room_vacancy_tbl">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Block</th>
                                        <th>Floor No</th>
                                        <th>Room No</th>
                                        <th>Room Type</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($vacant_room_data)) {
                                        foreach ($vacant_room_data as $key => $data) { ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><i class="fa fa-building text-info" aria-hidden="true"></i>&nbsp;
                                                    <?= $data['BLOCK_NAME']; ?>
                                                </td>
                                                <td><?= $data['FLOOR_NAME']; ?></td>
                                                <td>
                                                    <?php if ($data['ROOM_NO'] != "") { ?>
                                                        <i class="fa fa-home text-success" aria-hidden="true"></i>&nbsp;
                                                        <?= $data['ROOM_NO']; ?>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $data['BED_TYPE_NAME']; ?></td>
                                                <td><?= $data['ROOM_DESCRIPTION']; ?></td>
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
        $('#room_vacancy_tbl').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
        $('#v_date').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: new Date()
        });
    });
</script>