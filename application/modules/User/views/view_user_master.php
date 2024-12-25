<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered" id="user_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>User Details</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Contact No</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>View Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($user_data)) {
                                        foreach ($user_data as $key => $data) {
                                            $dob = $data['DOB'];
                                            $age = '';
                                            if (!empty($dob)) {
                                                $dobDateTime = new DateTime($dob);
                                                $currentDate = new DateTime();
                                                $age = $currentDate->diff($dobDateTime)->y;
                                            } ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td>
                                                    <i class="fa fa-user text-success" aria-hidden="true"></i>&nbsp;
                                                    <?= $data['E_NAME'] ?>
                                                    <br>
                                                    <span class="label bg-aqua">
                                                        <?= $age ?> yr / <?= $data['GENDER']; ?>
                                                    </span>
                                                </td>
                                                <td><i class="fa fa-building-o text-warning" aria-hidden="true"></i>
                                                    <?= $data['DEPARTMENT_NAME']; ?></td>
                                                <td><label class="label label-warning"><?= $data['DESIGNATION_NAME']; ?></label>
                                                </td>
                                                <td><i class="fa fa-phone text-danger"></i> <?= $data['CONTACT_NUMBER']; ?>
                                                </td>
                                                <td><?= date('d-m-Y', strtotime($data['DOB'])); ?></td>
                                                <td><?= $data['GENDER']; ?></td>
                                                <td><i class="fa fa-map-marker text-danger" aria-hidden="true"></i>
                                                    <?= $data['PRESENT_ADDRESS']; ?></td>
                                                <td><a href="<?= base_url('resources/uploads/user_image/' . $data['AVATAR']); ?>"
                                                        target="_blank" class="btn btn-success btn-sm"><i class="fa fa-eye"></i>
                                                        View</a>
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
                                                                    onclick="editMode('<?= $this->my_encryption->encrypt($data['USER_CODE']) ?>')"><i
                                                                        class="fa fa-edit"></i>&nbsp;Edit</a>
                                                            </li>
                                                            <li>
                                                                <a></a>
                                                                <?php
                                                                if ($data['ACTIVE_STATUS'] == 'ACTIVE') {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="updateStatus('<?= $this->my_encryption->encrypt($data['USER_CODE']) ?>')"><i
                                                                            class="fa fa-trash"></i>&nbsp;Delete</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        }
                                    }
                                    ?>
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

        $('#user_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
    });
    function updateStatus(id) {
        if (confirm('Are you sure you want to delete this data?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('custom_form').action = "<?= base_url('User/inactive_data_view_user_master') ?>";
            document.getElementById('custom_form').submit();
        }
    }
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_user';
        document.getElementById('custom_form').action = "<?= base_url('create-user') ?>";
        document.getElementById('custom_form').submit();
    }
    <?php
    if ($this->session->flashdata('update_msg')) {
        $msg = $this->session->flashdata('update_msg');
        if ($msg["status"] == '1') {
            ?>
            $.toast({
                heading: "Warning",
                text: "<?= $msg["message"] ?>",
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
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