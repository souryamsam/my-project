<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="<?php echo base_url('Master/save_room_service_type'); ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <span class="h5">Room Service Type</span>
                        <a class="float-end btn btn-blue btn-sm"
                            href="<?php echo base_url('room-service-type-list-view'); ?>"><i class="fa fa-list"></i>
                            View</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-1">Service Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="supplier_name"
                                    value="<?php echo set_value('supplier_name'); ?>">
                                <?php echo form_error('supplier_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <button type="submit" class="btn btn-success btn-sm"><i
                                    class="fa fa-save"></i>&nbsp;Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

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