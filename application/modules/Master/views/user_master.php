<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="h5">User Master</span>
                        <a class="float-end btn btn-blue btn-sm" href="view-user.html"><i class="fa fa-list"></i> View
                            User</a>
                    </div>
                    <form action="<?php echo base_url('Master/user_master_data_insert'); ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="mb-1">User Name</label>
                                    <input type="text" class="form-control form-control-sm" name="user_name"
                                        value="<?php echo set_value('user_name'); ?>">
                                    <?php echo form_error('user_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-1">User Contact No</label>
                                    <input type="text" class="form-control form-control-sm number" minlength="10"
                                        maxlength="10" name="contact_no" value="<?php echo set_value('contact_no'); ?>">
                                    <?php echo form_error('contact_no', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-1">User DOB</label>
                                    <input type="date" class="form-control form-control-sm" name="dob"
                                        value="<?php echo set_value('dob'); ?>">
                                    <?php echo form_error('dob', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-1">User Email</label>
                                    <input type="email" class="form-control form-control-sm" name="email"
                                        value="<?php echo set_value('email'); ?>">
                                    <?php echo form_error('email', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-6">
                                    <label class="mb-1">Present Address</label>
                                    <textarea class="form-control" name="address" id="present_add"
                                        value="<?php echo set_value('address'); ?>"></textarea>
                                    <?php echo form_error('address', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1">Parmanent Address <input type="checkbox" id="p_address"></label>
                                    <textarea class="form-control" name="p_address" id="parmanent_add"
                                        value="<?php echo set_value('p_address'); ?>"></textarea>
                                    <?php echo form_error('p_address', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-4">
                                    <label class="mb-1">department</label>
                                    <select class="form-select form-select-sm" name="dep">
                                        <option value="">select</option>
                                        <?php
                                        if (!empty($user_data[0])) {
                                            foreach ($user_data[0] as $srow) {

                                                ?>
                                                <option value="<?= $this->my_encryption->decrypt($srow['RECORD_ID']) ?>">
                                                    <?= $srow['RECORD_NAME'] ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-1">User Role</label>
                                    <select class="form-select form-select-sm" name="user_role">
                                        <option value="">select</option>
                                        <?php
                                        if (!empty($user_data[1])) {
                                            foreach ($user_data[1] as $rrow) {

                                                ?>
                                                <option value="<?= $this->my_encryption->encrypt($rrow['ROLE_ID']) ?>">
                                                    <?= $rrow['ROLE_NAME'] ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-1">Upload Profile Picture</label>
                                    <input class="form-control form-control-sm" type="file" id="formFile"
                                        name="profile_picture">
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <label class="mb-1">Aadhaar No</label>
                                    <input type="text" class="form-control form-control-sm" name="aadhaarno"
                                        value="<?php echo set_value('aadhaarno'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-1">Upload Aadhaar No</label>
                                    <input class="form-control form-control-sm" type="file" id="formFile"
                                        name="aadhaar_photo">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-1">Pan No</label>
                                    <input type="text" class="form-control form-control-sm" name="pan_no"
                                        value="<?php echo set_value('pan_no'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-1">Upload Pan No</label>
                                    <input class="form-control form-control-sm" type="file" id="formFile"
                                        name="pan_photo">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-end">
                                <button type="submit" class="btn btn-success btn-sm"><i
                                        class="fa fa-save"></i>&nbsp;Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
<script>
    $(document).ready(function () {
        $("#present_add").click(function () {
            var status = this.checked;
            if (status == true) {
                document.getElementById('parmanent_add').value = document.getElementById('present_add').value;
            } else {
                document.getElementById('parmanent_add').value = '';
            }
        })
    })
    <?php
    if ($this->session->flashdata('msg')) {
        $msg = $this->session->flashdata('msg');
        if ($msg["status"] == '1') {
            ?>
            $.toast({
                title: "Success!",
                text: "<?= $msg["message"] ?>",
                showHideTransition: "fade",
                position: "top-right",
                type: "success",
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