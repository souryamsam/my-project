<?php
if (!empty($single_parent_data)) {
    $dish_id = $this->my_encryption->encrypt($single_parent_data['DISH_ID']);
    $dish_category = $single_parent_data['DISH_CATEGORY'];
    $dish_name = $single_parent_data['DISH_NAME'];
    $dish_price = number_format($single_parent_data['DISH_PRICE'], 0);
    $dish_description = $single_parent_data['DISH_DESCRIPTION'];
    $btn = 'Update';
} else {
    $dish_id = '';
    $dish_category = '';
    $dish_name = '';
    $dish_price = '';
    $dish_description = '';
    $btn = 'Save';
}
$ingredient = [];
if (isset($_POST["ingredients_post_data"]) && $_POST["ingredients_post_data"] == 'ingredients_name') {
    foreach ($_POST['ingredients'] as $key => $ingredient_name) {
        $ingredient[] = array(
            'ingredient' => $ingredient_name,
            'ingredient_id' => $_POST['ingredients_name'][$key],
            'qty_per_dish' => $_POST['qty_per_dish'][$key],
            'unit' => $_POST['unit'][$key]
        );
    }
} else {
    $ingredient = '';
}
?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <?= form_open(base_url('Master/restaurant_menu_master_insert'), ['id' => 'restaurant_form']); ?>
                <input type="hidden" name="dish_id" value="<?= $dish_id ?>">
                <input type="hidden" name="ingredients_post_data" value="ingredients_name">
                <div class="box-header with-border ">
                    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('view-food-master'); ?>"><i
                            class="fa fa-list"></i> View Menus</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dish Category <span class="text-danger">*</span></label>
                                <select class="form-control input-sm" id="item_type" name="dis_caregory" required>
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($dish_category_data)) {
                                        foreach ($dish_category_data as $dish) {
                                            ?>
                                            <option value="<?= $this->my_encryption->encrypt($dish['RECORD_ID']) ?>"
                                                <?= (set_select('dis_caregory', $this->my_encryption->encrypt($dish['RECORD_ID']))) ? 'selected' : '' ?>
                                                <?= $dish['RECORD_ID'] == $dish_category ? 'selected' : '' ?>>
                                                <?= $dish['RECORD_NAME'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?= form_error('dis_caregory', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Dish Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm" name="dish_name"
                                    style="text-transform: uppercase"
                                    value="<?= $dish_name ?><?= set_value('dish_name'); ?>" required>
                                <?= form_error('dish_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Dish Price(Rs) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm number" name="dish_price"
                                    style="text-transform: uppercase"
                                    value="<?= $dish_price ?><?= set_value('dish_price'); ?>" required>
                                <?= form_error('dish_price', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered"
                                    id="food_master_table">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>Ingredients Name</th>
                                            <th>Qty Per Dish</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-control input-sm select2" id="ingr_name"
                                                    name="ingredients_name">
                                                    <option value="">Select</option>
                                                    <?php if (!empty($ingredients_name_data)): ?>
                                                        <?php foreach ($ingredients_name_data as $ingredients): ?>
                                                            <option
                                                                value="<?= $this->my_encryption->encrypt($ingredients['RECORD_ID']) ?>">
                                                                <?= $ingredients['RECORD_NAME'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm number" id="per_dish"
                                                    name="qty_per_dish">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="unit" name="unit"
                                                    readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" onclick="addRow()"
                                                    id="add_ingredients_button"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id="dynamic_table_body">
                                        <?php
                                        if (!empty($single_child_data)) {
                                            foreach ($single_child_data as $child_data) { ?>
                                                <tr>
                                                    <input type="hidden" name="ingredients_id[]"
                                                        value="<?= $this->my_encryption->encrypt($child_data['INGREDIENT_ID']); ?>">
                                                    <input type="hidden" name="ingredients_name[]"
                                                        value="<?= $this->my_encryption->encrypt($child_data['INGREDIENT_NAME']); ?>">
                                                    <td><?= $child_data['INGREDIENT_NAME_NAME']; ?></td>
                                                    <input type="hidden" name="qty_per_dish[]"
                                                        value="<?= $child_data['QTY_PER_DISH']; ?>">
                                                    <td><?= number_format($child_data['QTY_PER_DISH'], 0); ?></td>
                                                    <input type="hidden" name="unit[]" value="<?= $child_data['UNIT']; ?>">
                                                    <td><?= $child_data['UNIT']; ?></td>
                                                    <td><button type="button" onclick="deleteRow(this)"
                                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } ?>
                                        <?php
                                        if (isset($_POST["ingredients_post_data"]) && $_POST["ingredients_post_data"] == 'ingredients_name') {
                                            foreach ($ingredient as $key => $ing) {
                                                ?>
                                                <tr>
                                                    <input type="hidden" name="ingredients_name[]"
                                                        value="<?= $ing['ingredient_id'] ?>">
                                                    <td><?= $ing['ingredient'] ?></td>
                                                    <input type="hidden" name="qty_per_dish[]"
                                                        value="<?= $ing['qty_per_dish']; ?>">
                                                    <td><?= $ing['qty_per_dish'] ?></td>
                                                    <input type="hidden" name="unit[]" value="<?= $ing['unit']; ?>">
                                                    <td><?= $ing['unit'] ?></td>
                                                    <td><button type="button" onclick="deleteRow(this)"
                                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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
                    <div class="row">
                        <div class="col-md-12">
                            <label>Description</label>
                            <input type="hidden" name="description" id="rest_desc"
                                value="<?= $dish_description; ?><?= set_value('description'); ?>" />
                            <div id="restaurant_desc" class="po_description_ckeditor BalloonEditor"
                                style="height:80px; border:1px solid #dedede;">
                                <?= $dish_description; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-info btn-sm" id="resetBtn"><i
                                class="fa fa-recycle"></i>&nbsp;Reset</button>
                        <button type="submit" id="submit_btn" class="btn btn-success btn-sm"><i
                                class="fa fa-save"></i>&nbsp;<?= $btn ?></button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

<script>
    let restaurant_desc_val;
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    });
    $(function () {
        BalloonEditor
            .create(document.querySelector('#restaurant_desc'), {})
            .then(editor => {
                restaurant_desc_val = editor;
                editor.setData($('#rest_desc').val());
            })
            .catch(error => {
                console.log(error);
            });

        $('#restaurant_form').on('submit', function (e) {
            let descriptionContent = restaurant_desc_val.getData().trim();
            $('#rest_desc').val(descriptionContent);
        });
    });
    function addRow() {
        var ingr = $("#ingr_name").val();
        var ingr_name = $("#ingr_name option:selected").text();
        var dish = $("#per_dish").val();
        var unit = $('#unit').val();

        if (ingr === "") {
            $.toast({
                heading: "Warning",
                text: 'Ingredients Name field is required.',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: true,
                timeout: 30000
            });
        } else if (dish === "") {
            $.toast({
                heading: "Warning",
                text: 'Qty Per Dish field is required.',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: true,
                timeout: 30000
            });
        } else if (unit === "") {
            $.toast({
                heading: "Warning",
                text: 'Unit field is required.',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: true,
                timeout: 30000
            });
        }
        else {
            var isDuplicate = false;
            $('#dynamic_table_body tr').each(function () {
                var existingIngr = $(this).find('input[name="ingredients_name[]"]').val();
                if (existingIngr === ingr) {
                    isDuplicate = true;
                    return false;
                }
            });
            if (isDuplicate) {
                $.toast({
                    heading: "Warning",
                    text: 'This ingredient has already been added. Please select a different ingredient..',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 40000
                });
                $('#ingr_name').val(null).trigger('change');
                $("#per_dish").val('');
                $("#unit").val('');
            } else {
                var newrow = '<tr>' +
                    '<input type="hidden" name="ingredients_name[]" value="' + ingr + '">' + '<input type="hidden" name="ingredients[]" value="' + ingr_name + '">' +
                    '<td>' + ingr_name + '</td>' +
                    '<input type="hidden" name="qty_per_dish[]" value="' + dish + '">' +
                    '<td>' + dish + '</td>' +
                    '<input type="hidden" name="unit[]" value="' + unit + '">' +
                    '<td>' + unit + '</td>' +
                    '<td><button type="button" onclick="deleteRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>';
                $('#dynamic_table_body').append(newrow);
                $('#ingr_name').val(null).trigger('change');
                $("#per_dish").val('');
                $("#unit").val('');
            }
        }
    }
    function deleteRow(button) {
        if (confirm('Are you sure you want to delete the data?')) {
            $(button).closest('tr').remove();
        }
    }
    $("#resetBtn").click(function () {
        $('#restaurant_form')[0].reset();
        $('#dynamic_table_body').empty();
        $('#item_type').val(null).trigger('change');
        $('#ingr_name').val(null).trigger('change');
        restaurant_desc_val.setData('');
    });
    $(document).ready(function () {
        $('#ingr_name').change(function () {
            var ingredients_name = $(this).val();
            $.ajax({
                url: baseurl + 'Master/fetch_unit_data',
                type: 'POST',
                data: {
                    ingredients_name: ingredients_name
                },
                dataType: 'json',
                success: function (res) {
                    if (res.status == '1') {
                        var unitName = res.data[0].DESC_2_NAME;
                        $('#unit').val(unitName);
                    };
                }
            });
        });
        $('#restaurant_form').submit(function () {
            var tr_length = $('#food_master_table tbody tr').length;
            if (tr_length > 0) {
                return true;
            } else {
                $.toast({
                    heading: "Warning",
                    text: 'You have not added any ingredients in this dish',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                return false;
            }
        });
    });
    <?php
    if ($this->session->flashdata('msg')) {
        $msg = $this->session->flashdata('msg');
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
</script>