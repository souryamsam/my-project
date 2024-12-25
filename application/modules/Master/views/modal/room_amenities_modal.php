<div class="modal fade in" id="room_amenities_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="javascript:void(0)" id="amenitites_form" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add Room Amenitites</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>New Amenities <span class="text-danger">*</span></label>
                                <input type="text" name="amenities" class="form-control input-sm" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="amenities_btn" class="btn btn-success btn-sm"><i
                            class="fa fa-save"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#amenitites_form').on('submit', function () {
            var formdata = $(this).serialize();
            $.ajax({
                url: baseurl + 'Master/room_amenities_master_insert',
                type: 'POST',
                dataType: 'json',
                data: formdata,
                beforeSend: function () {
                    $('#amenities_btn').prop('disabled', true);
                    $('#amenities_btn').removeClass('btn-success');
                    $('#amenities_btn').addClass('btn-danger');
                    $('#amenities_btn').html('<i class="fa fa-refresh"></i> Please Wait');
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
                        $('#amenitites_form')[0].reset();
                        $('#room_amenities_modal').modal('hide');
                        room_amenities_bind(response.new_id);
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
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
                complete: function () {
                    $('#amenities_btn').prop('disabled', false);
                    $('#amenities_btn').removeClass('btn-danger');
                    $('#amenities_btn').addClass('btn-success');
                    $('#amenities_btn').html('<i class="fa fa-save"></i> Add');
                }
            });
        });
    });
</script>