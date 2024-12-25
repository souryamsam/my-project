
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <!-- <div class="box-header with-border">
                                <a class="btn btn-primary btn-sm float-right" href="view-category-master.html">Item
                                    Category Master</a>
                            </div> -->
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('restaurant-food-master'); ?>"><i
                            class="fa fa-plus"></i> Add Menus</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered" id="restaurant_table">
                            <thead class="table-success">
                                <tr class="bg-primary">
                                    <th></th>
                                    <th>Category</th>
                                    <th>Dish Name</th>
                                    <th>Dish Price</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($parent_table_data)) {
                                    foreach ($parent_table_data as $parent_data) { ?>
                                        <tr class="parent-row">
                                            <td class="text-center">
                                                <span class="toggle-btn" onclick="toggleChildTable(this)"><i
                                                        class='fa fa-search-plus text-success'></i></span>
                                            </td>
                                            <td><?= $parent_data['DISH_CATEGORY_NAME'] ?></td>
                                            <td><?= $parent_data['DISH_NAME'] ?></td>
                                            <td class="text-end"><?= number_format($parent_data['DISH_PRICE'], 0) ?></td>
                                            <td><?= $parent_data['DISH_DESCRIPTION'] ?></td>

                                            <td>
                                                <?php
                                                        if ($parent_data['CURRENT_STATUS'] == 'ACTIVE') {
                                                            ?>
                                                            <label class="label label-success">ACTIVE</label>
                                                            <?php
                                                        } elseif ($parent_data['CURRENT_STATUS'] == 'INACTIVE') {
                                                            ?>
                                                            <label class="label label-danger">INACTIVE</label>
                                                            <?php
                                                        }
                                                        ?></td>
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
                                                                onclick="editMode('<?= $this->my_encryption->encrypt($parent_data['DISH_ID']) ?>')"><i
                                                                    class="fa fa-edit"></i>&nbsp;Edit</a>
                                                        </li>
                                                        <li>
                                                            <?php
                                                                    if ($parent_data['CURRENT_STATUS'] == 'ACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($parent_data['DISH_ID']) ?>', 'INACTIVE')"><i
                                                                                class="fa fa-close"></i>&nbsp;Inactive</a>
                                                                        <?php
                                                                    } elseif ($parent_data['CURRENT_STATUS'] == 'INACTIVE') {
                                                                        ?>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="updateStatus('<?= $this->my_encryption->encrypt($parent_data['DISH_ID']) ?>', 'ACTIVE')"><i
                                                                                class="fa fa-check"></i>&nbsp;Active</a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr class="child-table" style="display: none;">
                                            <td colspan="8">
                                                <table class="table table-condensed table-bordered table-striped mb-0">
                                                    <thead class="table-secondary">
                                                        <tr class="bg-info">
                                                            <th>Ingredients Name</th>
                                                            <th>Qty Per Dish</th>
                                                            <th>Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($child_table_data as $child_data) {
                                                            if ($child_data['DISH_ID'] == $parent_data['DISH_ID']) { ?>
                                                                <tr>
                                                                    <td><?= $child_data['INGREDIENT_NAME_NAME'] ?></td>
                                                                    <td class="text-end"><?= number_format($child_data['QTY_PER_DISH'], 0) ?></td>
                                                                    <td><?= $child_data['UNIT'] ?></td>
                                                                </tr>
                                                            <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
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
            document.getElementById('custom_form').action = "<?= base_url('Master/update_restaurant_menu_master_status') ?>";
                document.getElementById('custom_form').submit();
            }
        }
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_restaurant_food';
        document.getElementById('custom_form').action = "<?= base_url('restaurant-food-master') ?>";
        document.getElementById('custom_form').submit();
    }
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    });
    function toggleChildTable(button) {
        const parentRow = button.closest(".parent-row");
        const childTable = parentRow.nextElementSibling;

        if (childTable.style.display === "none") {
            childTable.style.display = "table-row";
            button.innerHTML = "<i class='fa fa-search-minus text-danger'></i>";
        } else {
            childTable.style.display = "none";
            button.innerHTML = "<i class='fa fa-search-plus text-success'></i>";
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