<section class="content">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url("bed-type-master"); ?>"><i
                            class="fa fa-plus"></i> Add Bed Type</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped" id="bed_type">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Bed Type</th>
                                            <th>Current Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($bed_master[0])) {
                                            foreach ($bed_master[0] as $bed_data) { ?>
                                                <tr>
                                                    <td>
                                                        <?= $bed_data['RECORD_NAME'] ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($bed_data['ACTIVE_STATUS'] == 'ACTIVE') {
                                                            ?>
                                                            <label class="label label-success">ACTIVE</label>
                                                            <?php
                                                        } elseif ($bed_data['ACTIVE_STATUS'] == 'INACTIVE') {
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
                                                                        onclick="editMode('<?= $this->my_encryption->encrypt($bed_data['RECORD_ID']) ?>')"><i
                                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                                </li>
                                                                <li>
                                                                    <?php
                                                                    if ($bed_data['ACTIVE_STATUS'] == 'ACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($bed_data['RECORD_ID']) ?>', 'INACTIVE')"><i
                                                                                class="fa fa-close"></i>&nbsp;Inactive</a>
                                                                        <?php
                                                                    } elseif ($bed_data['ACTIVE_STATUS'] == 'INACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($bed_data['RECORD_ID']) ?>', 'ACTIVE')"><i
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
</section>
<script>
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_bed_type';
        document.getElementById('custom_form').action = "<?= base_url('bed-type-master') ?>";
        document.getElementById('custom_form').submit();
    }

    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change the status?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = status;
            document.getElementById('custom_form').action = "<?= base_url('Master/update_bed_type_master_status') ?>";
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
        $('#bed_type').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
    });
</script>