<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border ">
                     <a class="btn btn-primary btn-sm float-right" href="<?= base_url("agent-master"); ?>"><i class="fa fa-plus"></i> Add
                        Agent</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped" id="agent_table">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th style="width:30px">Sl No</th>
                                            <th>Agent Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Document</th>
                                            <th>Document ID No</th>
                                            <th>Document Photo</th>
                                            <th>Current Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($agent_master_data)) {
                                            foreach ($agent_master_data as $key => $data) { ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $data['RECORD_NAME'] ?></td>
                                                    <td><i class="fa fa-user"></i> &nbsp;<?= $data['DESC_1'] ?></td>
                                                    <td><?= $data['DESC_2'] ?></td>
                                                    <td><?= $data['DESC_3'] ?></td>
                                                    <td><?= $data['IDENTITY_NAME'] ?></td>
                                                    <td><?= $data['DESC_5'] ?></td>
                                                    <td>
                                                        <?php if (!empty($agent_file_names_array = explode(',', $data['DESC_6']))) { ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href="<?= base_url('resources/uploads/agent_image/' . $agent_file_names_array[0]) ?>"
                                                                data-lightbox="agent-images<?= $key ?>"
                                                                data-title="<?= $agent_file_names_array[0] ?>">View Images</a>
                                                            <?php foreach (array_slice($agent_file_names_array, 1) as $file_name) { ?>
                                                                <a href="<?= base_url('resources/uploads/agent_image/' . $file_name) ?>"
                                                                    data-lightbox="agent-images<?= $key ?>"
                                                                    data-title="<?= $file_name ?>" style="display: none;"></a>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($data['ACTIVE_STATUS'] == 'ACTIVE') {
                                                            ?>
                                                            <label class="label label-success">ACTIVE</label>
                                                            <?php
                                                        } elseif ($data['ACTIVE_STATUS'] == 'INACTIVE') {
                                                            ?>
                                                            <label class="label label-danger">INACTIVE</label>
                                                            <?php
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
                                                                        onclick="editMode('<?= $this->my_encryption->encrypt($data['RECORD_ID']) ?>')"><i
                                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                                </li>
                                                                <li>
                                                                    <?php
                                                                    if ($data['ACTIVE_STATUS'] == 'ACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($data['RECORD_ID']) ?>', 'INACTIVE')"><i
                                                                                class="fa fa-close"></i>&nbsp;Inactive</a>
                                                                        <?php
                                                                    } elseif ($data['ACTIVE_STATUS'] == 'INACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($data['RECORD_ID']) ?>', 'ACTIVE')"><i
                                                                                class="fa fa-check"></i>&nbsp;Active</a>
                                                                        <?php
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
    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change the status?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = status;
            document.getElementById('custom_form').action = "<?= base_url('Master/update_agent_master_status') ?>";
            document.getElementById('custom_form').submit();
        }
    }
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_agent';
        document.getElementById('custom_form').action = "<?= base_url('agent-master') ?>";
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
    $(document).ready(function () {
        $('#agent_table').DataTable({
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