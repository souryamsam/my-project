<?php
// print_r(value: $pages);die;
$role = isset($role_name['USER_GROUP_NAME']) ? $role_name['USER_GROUP_NAME'] : '';
$ug_id = isset($role_name['UG_ID']) ? $role_name['UG_ID'] : '';
$selected_page = array_column($pages, 'PAGE_ID');
$selected_privilege = array_column($privilege, 'PRIVILEDGE_CODE');
?>
<div class="row">
    <?= form_open('User/create_role_insert', ['id' => 'roleform']) ?>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Role Name<span
                                        class="required_span">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="role_name" id="role_name" class="form-control input-sm" value="<?=$role?>">
                                    <?= form_error('role_name', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <input type="hidden" name="user_group" value="<?=$this->my_encryption->encrypt($ug_id)?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a class="btn btn-success btn-sm" href="<?= base_url('role-list-view') ?>"><i
                                class="fa fa-list"></i> View Role Master</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-8">
                                    <strong style="font-size: 16px;">Menu Wise Page Details</strong>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="TreeView1">
                                        <?php
                                        if (!empty($super_menus)) {
                                            foreach ($super_menus as $i => $menus) {
                                                ?>

                                                <!-- Dashboard Section -->
                                                <table cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="toggleCollapse('Nodes<?= $i ?>', 'collapseIcon<?= $i ?>');">
                                                                    <i id="collapseIcon<?= $i ?>"
                                                                        title="Collapse <?= $menus['MENU_NAME'] ?>"
                                                                        class="fa fa-minus"></i>&nbsp;&nbsp;&nbsp;
                                                                </a>
                                                            </td>
                                                            <td class="treeNode rootNode" style="padding: 5px;">
                                                                <input type="checkbox" id="checkAll<?= $i ?>">
                                                                <span style="font-size:16px;color: rgb(48, 120, 222);">
                                                                    <?= $menus['MENU_NAME'] ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div id="Nodes<?= $i ?>"
                                                    style="display: block; background-color: #eeeeee;padding: 5px;">
                                                    <?php
                                                    if (!empty($sub_menus)) {
                                                        foreach ($sub_menus as $idx => $menu_val) {
                                                            if ($menu_val['MENU_ID'] == $menus['MENU_ID']) {
                                                                ?>
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div style="width:30px;"></div>
                                                                            </td>
                                                                            <td class="treeNode leafNode">
                                                                                <input type="checkbox" class="chkbox page<?= $i ?>"
                                                                                    name="page_id[]"
                                                                                    value="<?= $this->my_encryption->encrypt($menu_val['PAGE_ID']) ?>"
                                                                                    <?=in_array($menu_val['PAGE_ID'], $selected_page)?'checked':''?>>
                                                                                <span
                                                                                    style="font-size:1em;"><?= $menu_val['PAGE_APP_NAME'] ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#checkAll<?= $i ?>").click(function () {
                                                            $(".page<?= $i ?>").prop('checked', $(this).prop('checked'));
                                                        });
                                                    });

                                                </script>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-8">
                                    <strong style="font-size: 16px;">Special Privileges</strong>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Privilege Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($privileges)) {
                                                    foreach ($privileges as $key => $p_value) {
                                                        ?>

                                                        <tr>
                                                            <td><?= $key + 1 ?></td>
                                                            <td><?= $p_value['RECORD_NAME'] ?></td>
                                                            <td>
                                                                <input type="checkbox" class="privilegecheck"
                                                                    name="privilege_id[]"
                                                                    value="<?= $this->my_encryption->encrypt($p_value['RECORD_ID']) ?>"
                                                                    <?=in_array($p_value['RECORD_ID'], $selected_privilege)?'checked':''?>>
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
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i>
                                Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>
<script>
    $(function () {
        'use strict';

        $('[data-toggle="push-menu"]').pushMenu('toggle');
        let isDuplicate = false;
        $('#role_name').on('keyup', function () {
            var role_name = $(this).val();
            $.ajax({
                url: baseurl + 'User/role_name_duplicate_checking',
                type: 'POST',
                dataType: 'json',
                data: {
                    role_name: role_name,
                },
                success: function (response) {
                    if (response.status == '1') {
                        $.toast({
                            heading: "Warning",
                            text: response.message,
                            showHideTransition: "fade",
                            position: "top-right",
                            icon: "error",
                            loader: true,
                            timeout: 5000
                        });
                        isDuplicate = true;
                    } else {
                        isDuplicate = false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        });
        $('#roleform').submit(function () {
            var rolecheck = $('.chkbox:checked').length;
            var privilegecheck = $('.privilegecheck:checked').length;
            var rolename = $('#role_name').val();

            if (rolename === '') {
                $.toast({
                    heading: "Warning",
                    text: "Please enter the role name.",
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                return false;
            } else if (rolecheck === 0 || privilegecheck === 0) {
                $.toast({
                    heading: "Warning",
                    text: "Please select at least one role and privilege checkbox.",
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                return false;
            } else if (isDuplicate == true) {
                $.toast({
                    heading: "Warning",
                    text: "This role name is alraedy exits.",
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                return false;
            } else {
                return true;
            }
        });



    });
    function toggleCollapse(nodeId, iconId) {
        var sectionNodes = document.getElementById(nodeId);
        var collapseIcon = document.getElementById(iconId);

        if (sectionNodes.style.display === 'none') {
            sectionNodes.style.display = 'block';
            collapseIcon.classList.remove('fa-plus');
            collapseIcon.classList.add('fa-minus');
            collapseIcon.title = 'Collapse';
        } else {
            sectionNodes.style.display = 'none';
            collapseIcon.classList.remove('fa-minus');
            collapseIcon.classList.add('fa-plus');
            collapseIcon.title = 'Expand';
        }
    }
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