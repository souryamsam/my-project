<div class="modal fade" id="manufacturerModal" tabindex="-1" aria-labelledby="manufacturerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" fdprocessedid="49mdpl">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Manufacturer</h4>
            </div>
            <form action="javascript:void(0)" id="manu" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Manufacturer Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control input-sm" name="manufacturer_name" required>
                    </div>
                    <div class="form-group">
                        <label>Manufacturer Address</label>
                        <textarea class="form-control input-sm" rows="4" name="manufacturer_address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="manu_btn" class="btn btn-success btn-sm"><i
                            class="fa fa-save"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#manu').on('submit', function (e) {
            e.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: baseurl + 'Master/manufacturer_modal_insert',
                type: 'POST',
                dataType: 'json',
                data: formdata,
                beforeSend: function () {
                    $('#manu_btn').prop('disabled', true);
                    $('#manu_btn').removeClass('btn-success');
                    $('#manu_btn').addClass('btn-danger');
                    $('#manu_btn').html('<i class="fa fa-refresh"></i> Please Wait');
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
                        $('#manu')[0].reset();
                        $('#manufacturerModal').modal('hide');
                        manufacturer_bind(response.new_id);
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
                        $('#manufacturerModal').modal('show');
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
                complete: function () {
                    $('#manu_btn').prop('disabled', false);
                    $('#manu_btn').removeClass('btn-danger');
                    $('#manu_btn').addClass('btn-success');
                    $('#manu_btn').html('<i class="fa fa-save"></i> Add');
                }
            });
        });
    });
</script>