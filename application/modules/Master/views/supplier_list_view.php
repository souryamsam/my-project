<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border ">
                <a class="btn btn-primary btn-sm float-right" href="<?= base_url("supplier-master"); ?>"><i
                        class="fa fa-plus"></i> Add
                    Supplier</a>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped" id="supplier_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Supplier Shop Name</th>
                                        <th>Supplier Contact Person</th>
                                        <th>Supplier Contact No</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Current Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($supplier_master_data[0])) {
                                        foreach ($supplier_master_data[0] as $user) { ?>
                                            <tr>
                                                <td><?= $user['RECORD_NAME'] ?></td>
                                                <td><i class="fa fa-user"></i> &nbsp;<?= $user['DESC_2'] ?></td>
                                                <td><?= $user['DESC_1'] ?></td>
                                                <td><?= $user['DESC_3'] ?></td>
                                                <td><?= $user['DESC_4'] ?></td>

                                                <td>
                                                    <?php
                                                    if ($user['ACTIVE_STATUS'] == 'ACTIVE') {
                                                        ?>
                                                        <label class="label label-success">ACTIVE</label>
                                                        <?php
                                                    } elseif ($user['ACTIVE_STATUS'] == 'INACTIVE') {
                                                        ?>
                                                        <label class="label label-danger">INACTIVE</label>
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
                                                                    onclick="editMode('<?= $this->my_encryption->encrypt($user['RECORD_ID']) ?>')"><i
                                                                        class="fa fa-edit"></i>&nbsp;Edit</a>
                                                            </li>

                                                            <li>
                                                                <?php
                                                                if ($user['ACTIVE_STATUS'] == 'ACTIVE') {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="updateStatus('<?= $this->my_encryption->encrypt($user['RECORD_ID']) ?>', 'INACTIVE')"><i
                                                                            class="fa fa-close"></i>&nbsp;Inactive</a>
                                                                    <?php
                                                                } elseif ($user['ACTIVE_STATUS'] == 'INACTIVE') {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="updateStatus('<?= $this->my_encryption->encrypt($user['RECORD_ID']) ?>', 'ACTIVE')"><i
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

<script>
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_supplier_list';
        document.getElementById('custom_form').action = "<?= base_url('supplier-master') ?>";
        document.getElementById('custom_form').submit();
    }

    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change the status?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = status;
            document.getElementById('custom_form').action = "<?= base_url('Master/update_supplier_list_status') ?>";
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
    $(document).ready(function () {
        $('#supplier_table').DataTable({
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
</script>