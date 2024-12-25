<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url("room-master"); ?>"><i
                            class="fa fa-plus"></i>
                        Add Room</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered"
                                    style="table-layout: fixed;" id="room_master">
                                    <thead class="bg-info">
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th style="width: 100px;">Floor No.</th>
                                            <th style="width: 100px;">Room No.</th>
                                            <th style="width: 100px;">Room Size</th>
                                            <th style="width: 130px;">Room Category</th>
                                            <th style="width: 100px;">Room Type</th>
                                            <th style="width: 120px;">Guest Capacity</th>
                                            <th style="width: 130px;">Bed Type</th>
                                            <th style="width: 100px;">Room Price</th>
                                            <th style="width: 100px;">Extra Guest</th>
                                            <th style="width: 100px;">Extra Cost</th>
                                            <th style="width: 100px;">View Photos</th>
                                            <th style="width: 200px;">Description</th>
                                            <th style="width: 150px;">Extra Amenities</th>
                                            <th style="width: 120px;">Current Status</th>
                                            <th style="width: 130px;">Room Status</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($room_master_data[0])) {
                                            foreach ($room_master_data[0] as $key => $room) {
                                                ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $room['FLOOR_NAME'] ?></td>
                                                    <td class="text-bold"><?= $room['ROOM_NO'] ?></td>
                                                    <td><?= $room['ROOM_SIZE'] ?> Sq-ft</td>
                                                    <td><?= $room['ROOM_CATEGORY_NAME'] ?></td>
                                                    <td><i class="fa-solid fa-fan"></i><?= $room['ROOM_TYPE_NAME'] ?></td>
                                                    <td class="text-center"><i class="fa fa-users" aria-hidden="true"
                                                            style="color: grey"></i> <b><?= $room['GUEST_CAPACITY'] ?></b></td>
                                                    <td><i class="fa fa-bed" style="color: #c0a600;"></i>
                                                        &nbsp;<?= $room['BED_TYPE_NAME'] ?></td>
                                                    <td><b>AC:
                                                        </b><?= $room['AC_ROOM_PRICE'] ?><br>
                                                        <?php if ($room['NON_AC_ROOM_PRICE']) { ?>
                                                            <b>NON-AC:</b>
                                                            <?= $room['NON_AC_ROOM_PRICE'] ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $room['EXTRA_GUEST'] ?></td>
                                                    <td><?= $room['EXTRA_COST'] ?></td>
                                                    <td>
                                                        <?php if (!empty($room_file_names_array = explode(',', $room['PHOTOS']))) { ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href="<?= base_url('resources/room_image/' . $room_file_names_array[0]) ?>"
                                                                data-lightbox="agent-images<?= $key ?>"
                                                                data-title="<?= $room_file_names_array[0] ?>"><i
                                                                    class="fa fa-image"></i></a>
                                                            <?php foreach (array_slice($room_file_names_array, 1) as $file_name) { ?>
                                                                <a href="<?= base_url('resources/room_image/' . $file_name) ?>"
                                                                    data-lightbox="agent-images<?= $key ?>"
                                                                    data-title="<?= $file_name ?>" style="display: none;"></a>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $room['ROOM_DESCRIPTION'] ?></td>
                                                    <td><?= $room['AMINITIES_NAME'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($room['ROOM_STATUS'] == 'ACTIVE') {
                                                            ?>
                                                            <label class="label label-success">ACTIVE</label>
                                                            <?php
                                                        } elseif ($room['ROOM_STATUS'] == 'INACTIVE') {
                                                            ?>
                                                            <label class="label label-danger">INACTIVE</label>
                                                            <?php
                                                        } else {
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($room['VECANT_STATUS'] == 'VECANT') {
                                                            ?>
                                                            <label class="label label-success">VECANT</label>
                                                            <?php
                                                        } elseif ($room['VECANT_STATUS'] == 'BOOKED') {
                                                            ?>
                                                            <label class="label label-danger">BOOKED</label>
                                                            <?php
                                                        } elseif (($room['VECANT_STATUS'] == 'ON CLEANING')) {
                                                            ?>
                                                            <label class="label label-warning">ON CLEANING</label>
                                                            <?php
                                                        } elseif (($room['VECANT_STATUS'] == 'ON MAINTENANCE')) {
                                                            ?>
                                                            <label class="label label-primary">ON MAINTENANCE</label>
                                                            <?php
                                                        } else {
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info btn-sm">Action</button>
                                                            <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu" style="right: 0;left: auto;">
                                                                <li>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="editMode('<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>')"><i
                                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                                </li>
                                                                <li>
                                                                    <?php
                                                                    if ($room['ROOM_STATUS'] == 'ACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>', 'INACTIVE')"><i
                                                                                class="fa fa-close"></i>&nbsp;Inactive</a>
                                                                        <?php
                                                                    } elseif ($room['ROOM_STATUS'] == 'INACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($room['ROOM_ID']) ?>', 'ACTIVE')"><i
                                                                                class="fa fa-check"></i>&nbsp;Active</a>
                                                                        <?php
                                                                    } else {
                                                                    }
                                                                    ?>
                                                                </li>
                                                            </ul>
                                                        </div>
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
</section>

<script>
    $(document).ready(function () {
        $('#room_master').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
    });
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change the status?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = status;
            document.getElementById('custom_form').action = "<?= base_url('Master/update_room_master_status') ?>";
            document.getElementById('custom_form').submit();
        }
    }
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_room';
        document.getElementById('custom_form').action = "<?= base_url('room-master') ?>";
        document.getElementById('custom_form').submit();
    }
    <?php
    if ($this->session->flashdata('update_msg')) {
        $msg = $this->session->flashdata('update_msg');
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
            })

            <?php
        }
        unset($_SESSION["update_msg"]);
    }
    ?>
</script>