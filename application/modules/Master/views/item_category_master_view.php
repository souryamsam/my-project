<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border ">
                <a class="btn btn-primary btn-sm float-right" href="<?= base_url("item-category-master"); ?>"><i
                        class="fa fa-plus"></i> Add Item
                    Category</a>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped" id="item_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Parent Category</th>
                                        <th>Child Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($item_category_data[1])) {
                                        foreach ($item_category_data[1] as $item) {
                                            ?>
                                            <tr>
                                                <td><?= $item['PARENT_NAME'] ?></td>
                                                <td><?= $item['CHILD_NAME'] ?></td>
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
                                                                    onclick="editMode('<?= $this->my_encryption->encrypt($item['CHILD_ID']) ?>')"><i
                                                                        class="fa fa-edit"></i>&nbsp;Edit</a>
                                                            </li>
                                                            <li>
                                                                <?php
                                                                if ($item['CHILD_HAVE'] == 'NO') {
                                                                    ?>
                                                                    <a href="javascript:void(0)" class="label-danger"
                                                                        onclick="updateStatus('<?= $this->my_encryption->encrypt($item['CHILD_ID']) ?>', 'INACTIVE')">
                                                                        <i class="fa fa-remove"></i>&nbsp;Remove</a>
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
    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change the status?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = status;
            document.getElementById('custom_form').action = "<?= base_url('Master/update_item_category_master_master_status') ?>";
            document.getElementById('custom_form').submit();
        }
    }
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_item';
        document.getElementById('custom_form').action = "<?= base_url('item-category-master') ?>";
        document.getElementById('custom_form').submit();
    }
    $(document).ready(function () {
        $('#item_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true
        });
    });
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
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
</script>