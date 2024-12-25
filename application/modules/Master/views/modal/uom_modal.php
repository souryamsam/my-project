<div class="modal fade" id="uomModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Unit</h4>
            </div>
            <form action="javascript:void(0)" id="uom" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Add New Unit<span class="text-danger">*</span></label>
                        <div>
                            <input type="text" class="form-control input-sm" name="uom" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="uom_btn" class="btn btn-success btn-sm"><i
                            class="fa fa-save"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#uom').on('submit', function (e) {
            e.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: baseurl + 'Master/uom_modal_insert',
                type: 'POST',
                dataType: 'json',
                data: formdata,
                beforeSend: function () {
                    $('#uom_btn').prop('disabled', true);
                    $('#uom_btn').removeClass('btn-success');
                    $('#uom_btn').addClass('btn-danger');
                    $('#uom_btn').html('<i class="fa fa-refresh"></i> Please Wait');
                },
                success: function (response) {
                    if (response.status == '1') {
                        $.toast({
                            heading: "Success!",
                            text: response.message,
                            showHideTransition: "fade",
                            position: "top-right",
                            icon: "success",
                            loader: true,
                            timeout: 30000
                        });
                        $('#uom')[0].reset();
                        $('#uomModal').modal('hide');
                        uom_bind(response.new_id);
                    } else {
                        $.toast({
                            heading: "Warning",
                            text: response.message,
                            showHideTransition: "fade",
                            position: "top-right",
                            icon: "error",
                            loader: true,
                            timeout: 30000
                        });
                        $('#uomModal').modal('show');
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
                complete: function () {
                    $('#uom_btn').prop('disabled', false);
                    $('#uom_btn').removeClass('btn-danger');
                    $('#uom_btn').addClass('btn-success');
                    $('#uom_btn').html('<i class="fa fa-save"></i> Add');
                }
            });
        });
    });
</script>