<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a class="btn btn-primary btn-sm float-right" href="payment-mode-register.html"><i
                            class="fa fa-list"></i> View Payment
                        Modes</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Payment Mode Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">No. of Text Fields <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-1">Text Field Names <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="float-right">
                        <button class="btn btn-info btn-sm"><i class="fa fa-recycle"></i>&nbsp;Reset</button>
                        <button class="btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<script>
    $(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');
    })
</script>