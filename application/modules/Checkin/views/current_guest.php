<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <!-- <div class="box-header with-border">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" class="form-control input-sm datepicker hasDatepicker" placeholder=""
                                id="dp1730787018302">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="display:block;">&nbsp;</label>
                            <a type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top"
                                data-original-title="Click to Search">
                                <span><i class="fa fa-search"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="box-body">
                <!-- <h4 style="margin-top: 0px;">Planned Check In Details for dd-mm-yyyy</h4>
                <hr style="border-color: rgb(189, 178, 178);margin-top: 5px;"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper"
                                class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="dataTables_length" id="DataTables_Table_0_length">
                                            <label>
                                                Show
                                                <select name="DataTables_Table_0_length"
                                                    aria-controls="DataTables_Table_0" class="form-control input-sm">
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="200">200</option>
                                                    <option value="300">300</option>
                                                    <option value="400">400</option>
                                                    <option value="500">500</option>
                                                </select>
                                                entries
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                            <label>Search:<input type="search" class="form-control input-sm"
                                                    placeholder="" aria-controls="DataTables_Table_0"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table
                                            class="table table-condensed table-hover table-bordered dataTable no-footer"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Sl. No: activate to sort column descending"
                                                        style="width: 33.7674px;">Sl. No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Customer Details: activate to sort column ascending"
                                                        style="width: 102.274px;">Customer Details</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Contact No.: activate to sort column ascending"
                                                        style="width: 78.8889px;">Contact No.</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Address: activate to sort column ascending"
                                                        style="width: 300.573px;">Address</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Check In Rooms: activate to sort column ascending"
                                                        style="width: 108.229px;">Check In Rooms</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="No. of Days Planned for Stay: activate to sort column ascending"
                                                        style="width: 161.128px;">No. of Days Planned for Stay</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Status: activate to sort column ascending"
                                                        style="width: 139.201px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Action: activate to sort column ascending"
                                                        style="width: 94.8264px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($current_guest_data)) {
                                                    foreach ($current_guest_data as $key => $data) {
                                                        ?>
                                                        <tr class="odd">
                                                            <td class="sorting_1"><?= $key + 1 ?></td>
                                                            <td><?= $data['GUEST_NAME'] ?></td>
                                                            <td><i class="fa fa-phone text-primary"></i>&nbsp;
                                                                <?= $data['CONTACT_NO'] ?>
                                                            </td>
                                                            <td><i class="fa fa-map-marker text-warning"
                                                                    aria-hidden="true"></i>&nbsp; <?= $data['ADDRESS'] ?>
                                                            </td>
                                                            <td><i class="fa fa-home text-primary" aria-hidden="true"></i>&nbsp;
                                                                <?= $data['ROOM_NO'] ?>
                                                            </td>
                                                            <td class="text-center"><b><?= $data['NO_DAYS'] ?></b></td>
                                                            <td>
                                                                <?php
                                                                if ($data['CHECKED_IN'] == 'YES') {
                                                                    ?>
                                                                    <label class="label label-success"
                                                                        style="display:inline-block;"><i
                                                                            class="fa fa-lock"></i>&nbsp;Checked In |
                                                                        <?= date('h:i a', strtotime($data['CHECKED_IN_TIME'])) ?>
                                                                    </label>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td> <!-- <a class=" btn btn-xs btn-primary"
                                                            href="edit-room-booking.html"
                                                            style="display:inline-block;"><i
                                                                class="fa fa-lock"></i>&nbsp;Initiate Check In</a> -->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                            aria-live="polite">Showing 1 to 2 of 2 entries</div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                            id="DataTables_Table_0_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button previous disabled"
                                                    id="DataTables_Table_0_previous"><a
                                                        aria-controls="DataTables_Table_0" aria-disabled="true"
                                                        role="link" data-dt-idx="previous" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="paginate_button active"><a href="#"
                                                        aria-controls="DataTables_Table_0" role="link"
                                                        aria-current="page" data-dt-idx="0" tabindex="0">1</a></li>
                                                <li class="paginate_button next disabled" id="DataTables_Table_0_next">
                                                    <a aria-controls="DataTables_Table_0" aria-disabled="true"
                                                        role="link" data-dt-idx="next" tabindex="-1">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    });
</script>