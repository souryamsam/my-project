<?php
$selected_room = $this->session->userdata('selected_room');
if (!empty($customer_data) || !empty($document_data)) {
    $guest_id = $this->my_encryption->encrypt($customer_data['GUEST_ID']);
    $guest_number = $customer_data['CONTACT_NO'];
    $guest_alt_number = $customer_data['ALT_CONTACT_NO'];
    $guest_email = $customer_data['EMAIL_ADDRESS'];
    $guest_name = $customer_data['GUEST_NAME'];
    $guest_dob = ($customer_data['DOB'] != '' && $customer_data['DOB'] != '1900-01-01') ? date('d-m-Y', strtotime($customer_data['DOB'])) : '';
    $guest_doa = ($customer_data['DOA'] != '' && $customer_data['DOA'] != '1900-01-01') ? date('d-m-Y', strtotime($customer_data['DOA'])) : '';
    $guest_address1 = $customer_data['ADDRESS_1'];
    $guest_address2 = $customer_data['ADDRESS_2'];
    $guest_city = $this->my_encryption->encrypt($customer_data['CITY']);
    $guest_state = $this->my_encryption->encrypt($customer_data['STATE']);
    $guest_country = $customer_data['COUNTRY'];
    $guest_pincode = $customer_data['PIN_CODE'];
    $guest_company_name = $customer_data['COMPANY_NAME'];
    $guest_gstno = $customer_data['GSTIN'];
    $guest_document_type = isset($document_data['DOCUMENT_TYPE']) ? $document_data['DOCUMENT_TYPE'] : null;
    $guest_file_name = isset($document_data['FILE_NAME']) ? $document_data['FILE_NAME'] : "no-image.png";
    $guest_id_card_number = isset($document_data['IDENTITY_NUMBER']) ? $document_data['IDENTITY_NUMBER'] : null;
    $readonly = "disabled";
    $edit = 'block';
} else {
    $guest_id = "";
    $guest_number = "";
    $guest_alt_number = "";
    $guest_email = "";
    $guest_name = "";
    $guest_dob = "";
    $guest_doa = "";
    $guest_address1 = "";
    $guest_address2 = "";
    $guest_city = set_value('city');
    $guest_state = set_value('state');
    $guest_country = set_value("country");
    $guest_pincode = "";
    $guest_company_name = "";
    $guest_gstno = "";
    $guest_document_type = "";
    $guest_file_name = "no-image.png";
    $guest_id_card_number = "";
    $readonly = "";
    $edit = 'none';
}
?>
<style>
   .loader {
        border: 5px solid #f3f3f3;
        border-top: 5px solid blue;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }
   
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<section class="content">
    <div class="row">
        <?php if ($selected_room) { ?>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title" style="width: 100%;"><i class="fa fa-shopping-cart"></i> Summary</h4>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <?php
                                                $overallTotalRate = 0.00;                                            
                                                
                                                if (!empty($selected_room)) {
                                                    // Group data by room_no and room_type
                                                    $groupedRooms = [];
                                                    foreach ($selected_room as $room) {
                                                        $groupedRooms[$room['room_no']][$room['room_type']][] = $room;
                                                    }
                                                    foreach ($groupedRooms as $room_no => $roomTypes) {
                                                        foreach ($roomTypes as $room_type => $rooms) {                                                          

                                                            // Dates for first check-in and last check-out
                                                            $checkInDate = new DateTime($rooms[0]['room_date']);
                                                            $checkOutDate = new DateTime(end($rooms)['room_date']);

                                                            // Set rent based on room type
                                                            $rent = ($room_type == 'AC') ? $rooms[0]['ac_rent'] : $rooms[0]['nonac_rent'];

                                                            // Calculate mattress cost in a single loop
                                                            $totalDays = 0;
                                                            $mattres_count = 0;
                                                            $mattressCost = 0.00;

                                                            foreach ($rooms as $room) {
                                                                if ($room['room_type'] == 'AC') {
                                                                    $totalDays ++;
                                                                }else{
                                                                    $totalDays ++;
                                                                }

                                                                if ($room['mattres'] == 'YES') {
                                                                    $mattressCost = $room['extra_cost'];
                                                                    $mattres_count ++;
                                                                }
                                                            }

                                                            // Calculate total rate for thisroom
                                                            $roomAmount = $rent * $totalDays;
                                                            $mattressAmount = $mattressCost * $mattres_count;
                                                            $totalRate = $roomAmount + $mattressAmount;
                                                            $overallTotalRate += $totalRate;
                                                            ?>
                                                                <tr>
                                                                    <td colspan="2" class="bg-primary">
                                                                        <h5><b>Check-In : <?= $checkInDate->format('d/m/Y') ?> | Check-Out :<?= $checkOutDate->format('d/m/Y') ?></b></h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <table class="table table-bordered" style="margin-bottom: 0px;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4">
                                                                                        <p style="margin: 0px;">
                                                                                            <span style="font-weight: 600;"><i class="fa fa-hashtag"></i> Room No :</span> <?= $room_no ?>
                                                                                        </p>
                                                                                        <p style="margin: 0px;">
                                                                                            <span style="font-weight: 600;"><i class="fa fa-home"></i> Room Category :</span> <?= $rooms[0]['room_category'] ?>
                                                                                        </p>
                                                                                        <p style="margin: 0px;">
                                                                                            <span style="font-weight: 600;"> <i class="fa fa-bed"></i> Bed Type :</span> <?= $rooms[0]['bed_type'] ?>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="bg-info">
                                                                                    <td></td>
                                                                                    <td style="font-weight: 600;">Rate</td>
                                                                                    <td style="font-weight: 600;">Day/Quantity
                                                                                    </td>
                                                                                    <td style="font-weight: 600;">Amount</td>
                                                                                </tr>
                                                                                <?php if ($room_type == 'AC'){ ?>
                                                                                <tr>
                                                                                    <td><i class="fa fa-snowflake-o"></i> AC</td>
                                                                                    <td class="text-right"><?= $rent ?></td>
                                                                                    <td class="text-right"><?= $totalDays ?></td>
                                                                                    <td class="text-right"><?=number_format($roomAmount,2)?></td>
                                                                                </tr>
                                                                                <?php } else { ?>
                                                                                <tr>
                                                                                    <td><i class="fa fa-sun-o"></i> Non-AC</td>
                                                                                    <td class="text-right"><?= $rent ?></td>
                                                                                    <td class="text-right"><?= $totalDays ?></td>
                                                                                    <td class="text-right"><?=number_format($roomAmount,2)?></td>
                                                                                </tr>
                                                                                <?php } if ($mattressCost > 0.00){ ?>
                                                                                <tr>
                                                                                    <td><i class="fa fa-bed"></i> Extra-Mattress</td>
                                                                                    <td class="text-right"><?= $mattressCost ?></td>
                                                                                    <td class="text-right"><?=$mattres_count?></td>
                                                                                    <td class="text-right"><?=number_format($mattressAmount,2)?></td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                                <tr class="bg-warning">
                                                                                    <td colspan="2"><b>Estimated Amount</b></td>
                                                                                    <td colspan="2" class="text-right"><?= number_format($totalRate,2)?></td>
                                                                                </tr>

                                                                                
                                                                            </tbody>

                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                            <tfoot>

                                                <tr>
                                                    <td>
                                                        <b>Total Estimated Amount:</b>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <i class="fa fa-inr"></i>
                                                        <span id="total_rate"><?= number_format($overallTotalRate, 2) ?></span>
                                                    </td>
                                                </tr>


                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-8">
            <div id="customer-master" style="">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Master</h3>
                        <?php if ($selected_room) { ?>
                            <div class="box-tools pull-right">
                                <a href="<?= base_url('room-booking') ?>">
                                    <button id="backbtn" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Click to Back"><i class="fa fa-arrow-left"></i></button>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <?= form_open(base_url('Master/customer_master_card_insert'), ['enctype' => 'multipart/form-data', 'id' => 'customer_master_form']) ?>
                    <div class="box-body">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <input type="hidden" name="guest_id" value="<?=$guest_id?>">
                                            <label>Contact No <span class="text-danger">*</span></label>
                                            <input type="text" maxlength="10" minlength="10" class="form-control number"
                                                placeholder="Contact No" name="mobile" <?= $readonly ?>
                                                onkeyup="duplicateCheck(event, this, 'CONTACT')"
                                                value="<?=set_value('mobile').$guest_number?>" id="contact_no" required>
                                            <?php echo form_error('mobile', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Alt. Contact No</label>
                                            <input type="text" maxlength="10" minlength="10" class="form-control number"
                                                placeholder="Alt. Contact No" name="alt_contact_no" <?= $readonly ?>
                                                value="<?= set_value('alt_contact_no').$guest_alt_number?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Customer Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Customer Name"
                                                style="text-transform: uppercase" name="customer_name" <?= $readonly ?>
                                                value="<?=set_value('customer_name') .$guest_name?>" onkeypress="return /[a-zA-Z\s]/i.test(event.key)" required>
                                            <?php echo form_error('customer_name', '<div class="text-danger text-capitalize">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Date of Birth</label>
                                            <input type="text" class="form-control datepicker"
                                                placeholder="Date of Birth" name="dob"
                                                value="<?=set_value('dob').$guest_dob?>" <?= $readonly ?>>
                                            <?= form_error('dob', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Date of Anniversary</label>
                                            <input type="text" class="form-control datepicker"
                                                placeholder="Date of Anniversary" name="doa"
                                                value="<?=set_value('doa').$guest_doa?>" <?= $readonly ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                Email Address</label>
                                            <input type="email" class="form-control" placeholder="Email Address"
                                                name="email" value="<?=set_value('email').$guest_email?>"
                                                oninput="enforce_lowercase_email(event)" <?= $readonly ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" placeholder="Company Name"
                                                style="text-transform: uppercase" name="company_name"
                                                value="<?=set_value('company_name').$guest_company_name?>"
                                                <?= $readonly ?>>
                                        </div>
                                        <div class="col-md-4">
                                            <label>GSTIN</label>
                                            <input type="text" class="form-control" placeholder="GSTIN"
                                                style="text-transform: uppercase" name="gst" id="gstin" minlength="15"
                                                onkeyup="duplicateCheck(event, this, 'GSTIN')"
                                                maxlength="15" value="<?=set_value('gst').$guest_gstno?>"
                                                <?= $readonly ?> oninput="enforce_uppercase_gstin(event)">
                                            <?= form_error('gst', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Address Line 1 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Address Line 1"
                                                style="text-transform: uppercase" name="address_one"
                                                value="<?=set_value('address_one').$guest_address1?>"
                                                <?= $readonly ?> required>
                                            <?= form_error('address_one', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Address Line 2</label>
                                            <input type="text" class="form-control" placeholder="Address Line 2"
                                                style="text-transform: uppercase" name="address_two"
                                                value="<?=set_value('address_two').$guest_address2?>"
                                                <?= $readonly ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Country <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="country" id="contry_id"
                                                <?= $readonly ?> required>
                                                <option value="">Select</option>
                                                <?php if (!empty($contry_data)) {
                                                    foreach ($contry_data as $srow) { ?>
                                                        <option value="<?= $this->my_encryption->encrypt($srow['RECORD_ID']) ?>"
                                                            <?= set_select('country', $this->my_encryption->encrypt($srow['RECORD_ID'])) ? 'selected' : '' ?>         <?= $srow['RECORD_ID'] == $guest_country ? 'selected' : '' ?>>
                                                            <?= $srow['RECORD_NAME'] ?>
                                                        </option>
                                                        <?php }
                                                } ?>
                                            </select>
                                            <?= form_error('country', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>State <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="state" id="state_value"
                                                <?= $readonly ?>>
                                                <option value="">Select</option>
                                            </select>
                                            <?= form_error('state', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>District <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="city" id="district_value"
                                                <?= $readonly ?>>
                                                <option value="">Select</option>
                                            </select>
                                            <?= form_error('city', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Pincode <span class="text-danger">*</span></label>
                                            <input type="text" maxlength="6" minlength="6" class="form-control number"
                                                placeholder="Pincode" name="pincode" <?= $readonly ?>
                                                value="<?=set_value('pincode').$guest_pincode?>" required>
                                            <?= form_error('pincode', '<div class="text-danger text-capitalize">', '</div>') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Document Type <span class="text-danger">*</span></label>
                                        <select class="form-control" name="id_document_type" id="id_document" <?= $readonly ?> required>
                                            <option selected="selected" value="">Select</option>
                                            <?php if (!empty($customer_master_data)) {
                                                foreach ($customer_master_data as $customer_data) { ?>
                                                    <option
                                                        value="<?= $this->my_encryption->encrypt($customer_data['RECORD_ID']) ?>"
                                                        <?= set_select('id_document', $this->my_encryption->encrypt($customer_data['RECORD_ID'])) ? 'selected' : '' ?>
                                                        <?= $customer_data['RECORD_ID'] == $guest_document_type ? 'selected' : '' ?>>
                                                        <?= $customer_data['DESC_1'] ?>
                                                    </option>
                                                    <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>ID Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder="ID No" id="id_no"
                                            style="text-transform: uppercase" name="id_no"
                                            onkeyup="duplicateCheck(event, this, 'IDENTITY')"
                                            value="<?= set_value('id_no').$guest_id_card_number?>"
                                            <?= $readonly ?> required>
                                        <?= form_error('id_no', '<div class="text-danger text-capitalize">', '</div>') ?>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="file_upload" class="form-label text-danger">( Only JPG & PNG is allowed )</label>
                                            <input type="file" id="file_upload" multiple=""class="form-control" 
                                            name="doc_photo[]" accept=".png, .jpg, .jpeg" <?=$readonly?>  >
                                        </div>
                                  </div>
                                <?php
                                     $guest_file_names_array = explode(',', $guest_file_name); 
                                ?>
                                    <div class="col-md-3">
                                        <div class="form-group" style="display:flex">
                                            <?php foreach ($guest_file_names_array as $file_name) { ?>
                                                <a href="<?= base_url('resources/uploads/customer_image/' . $file_name) ?>" data-lightbox="guest-images" data-title="<?= $file_name ?>">
                                                    <img class="viewimg" id="viewimg" src="<?= base_url('resources/uploads/customer_image/' . $file_name) ?>" style="height:100px;width:100px">
                                                    <input type="hidden" name="doc_photo[]" value="<?=$file_name?>" />
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="webcam"></div>
                                        <button type="button" id="capture"><i class="fa fa-camera"></i></button>
                                        <button type="button" id="reset"><i class="fa fa-refresh"></i></button>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Co-occupant Identity</h4>
                                    <hr>
                                    <table class="table table-responsive table-striped table-bordered" style="margin-top: -8px;" id="co_occupant_identity_id">
                                        <thead id="ContentPlaceHolder1_thdoc">
                                            <tr class="bg-secondary text-white">
                                                <th><label>Name / Id Number</label></th>
                                                <th><label>Relation</label></th>
                                                <th><label>Document Type</label></th>
                                                <th><label>Upload File</label></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <input type="text" style="text-transform: uppercase" class="form-control input-sm" id="co_name" <?= $readonly ?>>
                                                </th>
                                                <th>
                                                    <select class="form-control input-sm" id="relationship" <?= $readonly ?>>
                                                        <option selected="selected" value="">Select</option>
                                                        <option value="HUSBAND">Husband</option>
                                                        <option value="WIFE">Wife</option>
                                                        <option value="FATHER">Father</option>
                                                        <option value="MOTHER">Mother</option>
                                                        <option value="BROTHER">Brother</option>
                                                        <option value="SISTER">Sister</option>
                                                        <option value="FRIEND">Friend</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="form-control input-sm" id="co_document_type" <?= $readonly ?>>
                                                        <option selected="selected" value="">Select</option>
                                                            <?php if (!empty($customer_master_data)) {
                                                                foreach ($customer_master_data as $customer_data) { ?>
                                                                    <option
                                                                        value="<?= $this->my_encryption->encrypt($customer_data['RECORD_ID']) ?>">
                                                                        <?= $customer_data['DESC_1'] ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                    </select>
                                                </th>
                                                
                                                <th>
                                                    <input type="file" accept=".png, .jpg, .jpeg" id="co_file"
                                                        class="form-control" <?= $readonly ?>>
                                                </th>
                                                <th>
                                                    <button type="button" class="btn btn-primary btn-sm" id="addbtn"><i class="fa fa-plus"></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_tbl">
                                            <?php
                                            if(!empty($relatsion_data)){
                                                foreach($relatsion_data as $data_value){
                                                    ?>
                                                        <tr>
                                                            <td style="padding: 5px;"><?=$data_value['IDENTITY_NUMBER']?></td>
                                                            <input type="hidden" name="co_name[]" value="<?=$data_value['IDENTITY_NUMBER']?>">
                                                            <td style="padding: 5px;"><?=$data_value['RELATION']?></td>
                                                            <input type="hidden" name="relationship[]" value="<?=$data_value['RELATION']?>">
                                                            <td style="padding: 5px;"><?=$data_value['DOCUMENT_TYPE_NAME']?></td>
                                                            <input type="hidden" name="co_document_type[]" value="<?=$data_value['DOCUMENT_TYPE']?>">
                                                            <td style="text-align: center; padding: 5px;">
                                                                <?php if ($data_value['FILE_NAME'] != 'No File Upload') {
                                                                    ?>
                                                                    <img src="<?= base_url('resources/uploads/customer_image/' . $data_value['FILE_NAME']) ?>" width="70" height="70" alt="document image">
                                                                <?php } else { ?>
                                                                    <span>No File Uploaded</span>
                                                                <?php } ?>
                                                            </td>
                                                            <input type="hidden" name="co_file[]" value="<?=$data_value['FILE_NAME']?>">
                                                            <td>
                                                                <a class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></a>
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
                    <div class="box-footer">
                        <div class="float-right d-flex">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="paymentMode('<?=$guest_id?>')" style="display:<?=$guest_id !=''?'block':'none'?>">
                                <i class="fa fa-inr"></i> Proceed to Payment
                            </a>&nbsp;&nbsp;
                            <button type="submit" class="btn btn-sm btn-primary" id="proceedBtn" style="display:<?=$guest_id !=''?'none':'block'?>">
                                <i class='fa fa-save'></i> Save
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" id="editbtn" style="display:<?=$guest_id !=''?'block':'none'?>">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                        </div> 
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let addButtonClicked = false;
    $(document).ready(function () {
        'use strict';
        $('[data-toggle="push-menu"]').pushMenu('toggle');

        $('#id_document').on('change', function () {
            var selectedText = $.trim($("#id_document option:selected").text());
            if (selectedText == 'AADHAAR CARD') {
                $('#id_no').attr({minlength: 12,maxlength: 12});
            }else if (selectedText == 'PAN CARD') {
                $('#id_no').attr({minlength: 10,maxlength: 10});
            }else if (selectedText == 'DRIVING LICENCE') {
                $('#id_no').attr({minlength: 15,maxlength: 15});
            }else{ 
                $('#id_no').attr({minlength: 10,maxlength: 20});
            }
        });

        $('#file_upload').on('change', function(event) {
            const files = event.target.files;
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewimg').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } 
        });


        $('#editbtn').on('click', function(){
            $('#loader').show();
            $(".content-wrapper").hide();
            $(".main-footer").hide();
            setTimeout(function () {
                $('#loader').hide();
                $(".content-wrapper").show();
                $(".main-footer").show();
                $('#editbtn').hide();
                $('#proceedBtn').show();
                $('#proceedBtn').html('<i class="fa fa-save"></i> Update');
                $('.form-control').prop('disabled', false);
                $('input[type="file"]').prop('disabled', false);
                $('select').prop('disabled', false);
            }, 1000);
        });
        

        $('#addbtn').click(function() {
            var name = $('#co_name').val();
            var relationship = $('#relationship').val();
            var documentType = $.trim($('#co_document_type option:selected').text());
            var documentType_val = $('#co_document_type').val();
            var fileInput = $('#co_file')[0].files[0];
            addButtonClicked = true;
            if (name === '') {
                $.toast({
                    heading: "Warning",
                    text: 'Please enter name',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            }else if(relationship === ''){
                $.toast({
                    heading: "Warning",
                    text: 'Please select relationship',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            } else if (documentType_val === '') {
                $.toast({
                    heading: "Warning",
                    text: 'Please select the document type',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            } 
            /* else if (!fileInput) {
                $.toast({
                    heading: "Warning",
                    text: 'Please attach the document',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 30000
                });
            }  */
            else {
                // Create FormData object and append the file
                var formData = new FormData();
                formData.append('co_name', name);
                formData.append('co_document_type', documentType_val);
                formData.append('co_file', fileInput);
                if(fileInput){
                    $.ajax({
                        method: 'post',
                        url: baseurl + 'Master/customer_co_occupant_file',
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,

                        beforeSend: function () {
                            $('#addbtn').prop('disabled', true);
                            $('#addbtn').removeClass('btn-primary');
                            $('#addbtn').addClass('btn-danger');
                            $('#addbtn').html('<i class="fa fa-refresh fa-spin"></i>');
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.status == '1') {
                                $("#room_photo").val(result.file_name);
                                $.toast({
                                    heading: "Success!",
                                    text: result.message,
                                    showHideTransition: "fade",
                                    position: "top-right",
                                    icon: "success",
                                    loader: true,
                                    timeout: 30000
                                });

                                // Create an image URL for the uploaded file
                                var fileUrl = URL.createObjectURL(fileInput);
                                var newRow = '<tr>' +
                                    '<td>' + name + '</td>' +
                                    '<input type="hidden" name="co_name[]" value="'+ name +'">'+
                                    '<td>' + relationship + '</td>' +
                                    '<input type="hidden" name="relationship[]" value="'+ relationship +'">'+
                                    '<td>' + documentType + '</td>' +
                                    '<input type="hidden" name="co_document_type[]" value="'+ documentType_val +'">'+
                                    '<td class="text-center"><img src="' + fileUrl + '" width="70" height="70"></td>' +
                                    '<input type="hidden" name="co_file[]" value="'+ result.data +'">'+
                                    '<td><a class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></a></td>' +
                                    '</tr>';
                                $('#dynamic_tbl').append(newRow);
                            } else {
                                $.toast({
                                    heading: "Warning",
                                    text: result.message,
                                    showHideTransition: "fade",
                                    position: "top-right",
                                    icon: "error",
                                    loader: true,
                                    timeout: 30000
                                });
                            }
                        },

                        error: function(xhr) {
                            console.log(xhr);
                        },
                        complete: function () {
                            $('#addbtn').prop('disabled', false);
                            $('#addbtn').removeClass('btn-danger');
                            $('#addbtn').addClass('btn-primary');
                            $('#addbtn').html('<i class="fa fa-plus"></i>');
                        }
                    });
                }else{
                var newRow = '<tr>' +
                                '<td>' + name + '</td>' +
                                '<input type="hidden" name="co_name[]" value="'+ name +'">'+
                                '<td>' + relationship + '</td>' +
                                '<input type="hidden" name="relationship[]" value="'+ relationship +'">'+
                                '<td>' + documentType + '</td>' +
                                '<input type="hidden" name="co_document_type[]" value="'+ documentType_val +'">'+
                                '<td class="text-center">No File Uploaded</td>' +
                                '<input type="hidden" name="co_file[]" value="No File Upload">'+
                                '<td><a class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></a></td>' +
                                '</tr>';

                    $('#dynamic_tbl').append(newRow);
                }
                
                // Reset the input fields
                $('#co_name').val('');
                $('#relationship').val('');
                $('#co_document_type').val('');
                $('#co_file').val('');
            }
        });


        $(document).on('click', '.remove-row', function () {
            if (window.confirm("Are you sure that you want to delete this attachment?")) {
                $(this).closest('tr').remove();
            }
        });

        $('#contry_id').change(function () {
            var country = $(this).val();
            $.ajax({
                url: baseurl + 'Master/fetch_state_data',
                type: 'POST',
                data: {
                    country: country
                },
                dataType: 'json',
                success: function (res) {
                    var options = '<option value="">Select</option>';
                    if (res.status === '1') {
                        var state_code = '<?= $guest_state ?>';
                        $.each(res.data, function (key, value) {
                            var selected = (state_code == value.EN_STATE_CODE) ? 'selected' : '';
                            options += '<option value="' + value.EN_STATE_CODE + '" ' + selected + '>' + value.STATE_NAME + '</option>';
                        });
                    }
                    $('#state_value').html(options);
                    $('#state_value').trigger('change');
                },
            });
        });

        $('#state_value').change(function () {
            var state_code = $(this).val();
            $.ajax({
                url: baseurl + 'Master/fetch_district_data',
                type: 'POST',
                data: {
                    state_code: state_code
                },
                dataType: 'json',
                success: function (res) {
                    var options = '<option value="">Select</option>';
                    if (res.status === '1') {
                        var district_code = '<?= $guest_city ?>';
                        $.each(res.data, function (key, value) {
                            var selected = (district_code == value.EN_DISTRICT_CODE) ? 'selected' : ''
                            options += '<option value="' + value.EN_DISTRICT_CODE + '" ' + selected + '>' + value.DISTRICT + '</option>';
                        });
                    }
                    $('#district_value').html(options);
                },
            });
        });

        <?php if ($guest_country) { ?>
            $('#contry_id').trigger('change');
            <?php } ?>
      $('#customer_master_form').submit(function () {
        var co_name = $('#co_name').val();
        var relationship = $('#relationship').val();
        var co_document_type = $('#co_document_type').val();
        var co_file = $('#co_file').val();
        if (co_name !== '' || relationship !== '' || co_document_type !== '' || co_file !== '') {
            if (!addButtonClicked) {
                $.toast({
                    heading: "Warning",
                    text: 'Please click the "Add" button to add the co-occupant identity',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: true,
                    timeout: 3000
                });
                return false; 
            }
        }
    });
});

    
    function enforce_lowercase_email(event) {
        var input = event.target;
        input.value = input.value.toLowerCase();
    }
    function enforce_uppercase_gstin(event) {
        var input = event.target;
        input.value = input.value.toUpperCase();
    }
    function duplicateCheck(event,input,type) {
        event.preventDefault();
        inputValue = input.value;
        $.ajax({
            url:  baseurl + 'Master/duplicate_check', 
            type: 'POST',
            dataType: 'json',
            data: { 
                value: inputValue,
                type: type 
            },
            success: function(response) {
                if (response.status == 1) {
                    if (type == 'CONTACT') {
                        swal({
                            title: "Warning!",
                            text: "This phone number already exists. Do you want to proceed with a duplicate entry? If Yes, you can search for the existing account.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Yes',
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = baseurl+'room-booking'
                                return false;
                            } else {
                                swal("Cancelled", "", "error");
                                $('#contact_no').val('');
                            }
                        });
                        
                    } else if (type == 'IDENTITY') {
                        swal({
                            title: "Warning!",
                            text: "This Identity no. already exists.",
                            type: "warning",
                            buttons: true,
                            dangerMode: true,
                        });
                        $('#id_no').val('');
                    } else if (type == 'GSTIN') {
                        swal({
                            title: "Warning!",
                            text: "This GST no. already exists.",
                            type: "warning",
                            buttons: true,
                            dangerMode: true,
                        });
                        $('#gstin').val('');
                    }
                }
            },
            error: function(xhr) {
                console.log(xhr);
            },
        });
    }

    function paymentMode(id) {
        document.getElementById('custom_id').value = id;
        var booking_id = '<?=$this->uri->segment(3)?>';
        var slug = booking_id === '' ? "<?= base_url('payment-info') ?>" : '<?= base_url('payment-info/'.$this->uri->segment(3)) ?>';
        $("#custom_form").append('<input type="hidden" name="c_name" value="<?=$guest_name?>">');
        $("#custom_form").append('<input type="hidden" name="c_email" value="<?=$guest_email?>">');
        $("#custom_form").append('<input type="hidden" name="c_contactNo" value="<?=$guest_number?>">');
        $("#custom_form").append('<input type="hidden" name="c_address" value="<?=$guest_address1.' '.$guest_address2?>">');
        $("#custom_form").append('<input type="hidden" name="booking_id" value="'+booking_id+'">');
        document.getElementById('mode').value = 'payment_details';
        document.getElementById('custom_form').action = slug;
        document.getElementById('custom_form').submit();
    }
    <?php if ($this->session->flashdata('msg')) {
        $msg = $this->session->flashdata('msg');
        if ($msg["status"] == '1') { ?>
                swal({
                    title: "Success!",
                    text: "<?= $msg["message"] ?>",
                    icon: "success",
                    button: "OK",
                    timer: 3000
                });
            <?php } else { ?>
                swal({
                    title: "Warning",
                    text: "<?= $msg["message"] ?>",
                    icon: "error",
                    button: "OK",
                    timer: 3000
                });
            <?php }
        unset($_SESSION["msg"]);
    } ?>
</script>