<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title">Role View
        </h3>
    </div>
    <div class="box-body">
        <table class="table table-hover table-condensed" id="view_role_tbl">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Role Name</th>
                    <th>Create Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($view_role_page_data)) {
                    foreach ($view_role_page_data as $key => $data) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td>
                                <?= $data['USER_GROUP_NAME']; ?>
                            </td>
                            <td><?= date('d-m-Y H:i:s', strtotime($data['CREATE_DATE_TIME'])); ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Action</button>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="javascript:void(0)"
                                                onclick="editMode('<?= $this->my_encryption->encrypt($data['UG_ID']) ?>')"><i
                                                    class="fa fa-pencil text-green"></i>Edit Role</a>
                                        </li>
                                        <li>
                                            <?php
                                            if ($data['UG_ID'] == 'UG_1') { //here ug_id is admin id
                                                ?>
                                                <a href="javascript:void(0)"></a>
                                            <?php } elseif ($data['ACTIVE_STATUS'] == 'ACTIVE') {
                                                ?>
                                                <a href="javascript:void(0)"
                                                    onclick="updateStatus('<?= $this->my_encryption->encrypt($data['UG_ID']) ?>', 'INACTIVE')"><i
                                                        class="fa fa-times text-red"></i>&nbsp;Deactive</a>
                                            <?php } elseif ($data['ACTIVE_STATUS'] == 'INACTIVE') { ?>
                                                <a href="javascript:void(0)"
                                                    onclick="updateStatus('<?= $this->my_encryption->encrypt($data['UG_ID']) ?>', 'ACTIVE')"><i
                                                        class="fa fa-check text-green"></i>&nbsp;Active</a>
                                            <?php } ?>
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

<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');

        $('#view_role_tbl').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
    });
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_role';
        document.getElementById('custom_form').action = "<?= base_url('create-role') ?>";
        document.getElementById('custom_form').submit();
    }
    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change the status?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = status;
            document.getElementById('custom_form').action = "<?= base_url('User/update_role_master_status') ?>";
            document.getElementById('custom_form').submit();
        }
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