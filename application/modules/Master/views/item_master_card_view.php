<?php
if (isset($_POST["item_value"]) && $_POST["item_value"] == 'item_search_value') {
    $search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
    $item_type_data = isset($_POST['item_type']) ? $_POST['item_type'] : '';
    $search_value_data = isset($_POST['search_value']) ? $_POST['search_value'] : '';
    $item_category_data = isset($_POST['item_category']) ? $_POST['item_category'] : '';
} else {
    $search_type = '';
    $item_type_data = '';
    $search_value_data = '';
    $item_category_data = '';
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?= form_open(base_url('view-item')); ?>
                <input type="hidden" name="item_value" value="item_search_value">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Search by</label>
                            <select class="form-control input-sm search-dd" name="search_type" id="search_type">
                                <option value="">Select</option>
                                <option value="ITEM_TYPE" <?= ($search_type == 'ITEM_TYPE') ? 'selected' : '' ?>>Item
                                    Type</option>
                                <option value="STATUS" <?= ($search_type == 'STATUS') ? 'selected' : '' ?>>Status
                                </option>
                                <!-- <option value="UOM" <?= ($search_type == 'UOM') ? 'selected' : '' ?>>UOM</option> -->
                                <option value="MENUFACTURE" <?= ($search_type == 'MENUFACTURE') ? 'selected' : '' ?>>
                                    Manufacturer </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-5 hide2"
                                style="display: <?= ($search_type == 'ITEM_TYPE') ? 'block' : 'none' ?>;">
                                <div class="Item-Type"
                                    style="display: <?= ($search_type == 'ITEM_TYPE') ? 'block' : 'none' ?>;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Item Type</label>
                                                <select class="form-control input-sm" id="item_type" name="item_type">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (!empty($item_type)) {
                                                        foreach ($item_type as $brow) {
                                                            $encrypted_id = $this->my_encryption->encrypt($brow['RECORD_ID']);
                                                            $selected = ($encrypted_id == $item_type_data) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?= $encrypted_id ?>" <?= $selected ?>>
                                                                <?= $brow['RECORD_NAME'] ?>
                                                                <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Search_dropdown" style="display: 'none';">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label style="display:block;">&nbsp;</label>
                                                <select class=" form-control input-sm" name="search_value"
                                                    id="search_value">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 hide3"
                                style="display: <?= ($search_type == 'ITEM_TYPE') ? 'block' : 'none' ?>;">
                                <div class=" Item-category">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Item Category</label>
                                                <select class="form-control input-sm select2" name="item_category"
                                                    id="item_category">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label style="display:block;">&nbsp;</label>
                                    <button type="submit" class="btn btn-info btn-md" data-toggle="tooltip"
                                        data-placement="top" data-original-title="Click to Search">
                                        <span><i class="fa fa-search"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url("item-master"); ?>"><i
                            class="fa fa-plus"></i> Add Item</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped" id="item_master">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Item Type</th>
                                            <th>Item Category</th>
                                            <th>Item Name</th>
                                            <th>Item Details</th>
                                            <th>UOM</th>
                                            <th>Manufacturer</th>
                                            <th>Low Qty Level</th>
                                            <th>Current Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($item_data)) {
                                            foreach ($item_data as $data) { ?>
                                                <tr>
                                                    <td><?= $data['PARENT_RECORD_NAME']; ?></td>
                                                    <td><?= $data['ORIGINAL_NAME']; ?></td>
                                                    <td><?= $data['RECORD_NAME']; ?></td>
                                                    <td><?= $data['DESC_1']; ?></td>
                                                    <td><?= $data['DESC_2_NAME']; ?></td>
                                                    <td><?= $data['DESC_3_NAME']; ?></td>
                                                    <td></td>
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
                                                                                class="fa fa-ban"></i>&nbsp;Inactive</a>
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
        $(function () {
            'use strict';
            $('[data-toggle="push-menu"]').pushMenu('toggle');
        })
        function editMode(id) {
            document.getElementById('custom_id').value = id;
            document.getElementById('mode').value = 'edit_item_list';
            document.getElementById('custom_form').action = "<?= base_url('item-master') ?>";
            document.getElementById('custom_form').submit();
        }
        function updateStatus(id, status) {
            if (confirm('Are you sure you want to change the status?')) {
                document.getElementById('custom_id').value = id;
                document.getElementById('mode').value = status;
                document.getElementById('custom_form').action = "<?= base_url('Master/update_item_master_card_status') ?>";
                document.getElementById('custom_form').submit();
            }
        }
        $(document).ready(function () {
            $('#item_master').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "ordering": true
            });
            $('#search_type').change(function () {
                var search_type = $(this).val();
                $.ajax({
                    url: baseurl + 'Master/fetch_item_master_view_page_load_data',
                    type: 'POST',
                    data: {
                        search_type: search_type
                    },
                    dataType: 'json',
                    success: function (res) {
                        var options = '<option value="">Select</option>';
                        if (res.status === '1') {
                            var search_value = '<?= $search_value_data ?>';
                            $.each(res.data, function (key, value) {
                                var selected = (search_value == value.EN_RECORD_ID) ? 'selected' : '';
                                options += '<option value="' + value.EN_RECORD_ID + '" ' + selected + '>' + value.RECORD_NAME + '</option>';
                            });
                        }
                        $('#search_value').html(options);
                        $('#search_value').trigger('change');
                    }
                });
            });
            <?php
            if ($search_type) { ?>
                $('#search_type').trigger('change');
                <?php
            } ?>
            $('#item_type').change(function () {
                var item_category = $(this).val();
                $.ajax({
                    url: baseurl + 'Master/fetch_item_category_data',
                    type: 'POST',
                    data: {
                        item_category: item_category
                    },
                    dataType: 'json',
                    success: function (res) {
                        var options = '<option value="">Select</option>';
                        if (res.status === '1') {
                            var item_category = '<?= $item_category_data ?>';
                            $.each(res.data, function (key, value) {
                                var selected = (item_category == value.EN_RECORD_ID) ? 'selected' : '';
                                options += '<option value="' + value.EN_RECORD_ID + '" ' + selected + '>' + value.RECORD_NAME + '</option>';
                            });
                        }
                        $('#item_category').html(options);
                        $('#item_category').trigger('change');
                    },
                });

            });
            <?php
            if ($item_type_data) { ?>
                $('#item_type').trigger('change');
                <?php
            } ?>
        });
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
            unset($_SESSION["msg"]);
        }
        ?>
        $(".search-dd").on("change", function () {
            var selected = $(this).val();
            if (selected === "ITEM_TYPE") {
                $(".hide2").show();
                $(".hide3").show();
                $(".Item-Type").show();
                $(".Search_dropdown").hide();
            }
            else if (selected === "STATUS") {
                $(".hide2").show();
                $(".hide3").hide();
                $(".Item-Type").hide();
                $(".Search_dropdown").show();
            }
            else if (selected === "UOM") {
                $(".hide2").show();
                $(".hide3").hide();
                $(".Item-Type").hide();
                $(".Search_dropdown").show();
            }
            else if (selected === "MENUFACTURE") {
                $(".hide2").show();
                $(".hide3").hide();
                $(".Item-Type").hide();
                $(".Search_dropdown").show();

            }
            else {
                $(".hide2").hide();
                $(".hide3").hide();
                $(".Item-Type").hide();
                $(".Search_dropdown").hide();
            }
        });
    </script>