<?php
if(isset($patient_info_data) && !empty($patient_info_data)){
    $slug_name = $this->uri->segment(1);
    ?>
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
            <div class="col-sm-4 emr-info">
                <h3><?=$patient_info_data["NAME_AB_NEW"].' '.$patient_info_data["PT_NAME_NEW"]?></h3>
                <i class="fa fa-user text-green"></i>&nbsp;&nbsp;<?=$patient_info_data["GENDER_NEW"].(($patient_info_data["AGE"] != "")?' | '.$patient_info_data["AGE"]:'')?><br>
                <i class="fa fa-mobile-phone text-red"></i>&nbsp;&nbsp;Family Contact - <?=($patient_info_data["PT_CONTACT_NEW"] != "")?$patient_info_data["PT_CONTACT_NEW"]:$patient_info_data["ADMITTED_BY_CONTACT_NEW"]?><br>
                <i class="fa fa-id-badge text-yellow"></i>&nbsp;&nbsp;UHID - <?=$patient_info_data["UHID_ID"]?><br>
                <i class="fa fa-id-badge text-blue"></i>&nbsp;&nbsp;Regt. Dept. -&nbsp;<?=$patient_info_data["ADMISSION_DEPARTMENT_NAME"]?><br>
                <?=($patient_info_data["CURRENT_DEPARTMENT"] != "")?'<i class="fa fa-id-badge text-blue"></i>&nbsp;&nbsp;Current Dept. -&nbsp;<span class="label label-danger">'.$patient_info_data["CURRENT_DEPARTMENT"].'</span><br>':''?>
                <?=($patient_info_data["BED_NAME"] != "")?'<i class="fa fa-bed text-red"></i>&nbsp;&nbsp;Current Bed: -&nbsp;<span class="label label-success">'.$patient_info_data["BED_NAME"].'</span>':''?>
            </div>
            <div class="col-sm-4  emr-info">
                <address style="margin-top: 50px">
                    <strong><i class="fa fa-map-marker text-red"></i>&nbsp;Patient's Address</strong><br>
                    <?=($patient_info_data["ADDRESS_NEW"] != "")?$patient_info_data["ADDRESS_NEW"]:''?>, <?=$patient_info_data["PS_NEW"] != ""?$patient_info_data["PS_NEW"].'<br>':""?>
                    <?=($patient_info_data["CITY_NEW"] != "")?$patient_info_data["CITY_NEW"].'<br>':''?>
                    <?=$patient_info_data["STATE_NEW"].' - '.$patient_info_data["PINCODE_NEW"]?>
                </address>
            </div>
            <div class="col-sm-4  emr-info">
                <address style="margin-top: 50px">
                    <strong><i class="fa fa-id-card-o text-red"></i>&nbsp;EMR Details</strong><br>
                    EMR Date - <?=($patient_info_data["EMR_DATE"] != "")?date('d-m-Y',strtotime($patient_info_data["EMR_DATE"])):''?><br>
                    <?php
                    if($slug_name == 'electronic-medical-record-view' || $slug_name == 'electronic-medical-record-others-view') {
                        ?>
                        EMR Number - <?=$patient_info_data["EMR_ID"]?><br>
                        <?php
                    }
                    else{
                        ?>
                        EMR Number - <a href="<?=base_url("electronic-medical-record-others-view/".removeSpclchars($this->my_encryption->encrypt($patient_info_data["UHID_ID"])))?>" target="_blank" data-toggle="tooltip" title="View EMR"><?=$patient_info_data["EMR_ID"]?></a><br>
                        <?php
                    }
                    ?>
                    Last Visit Date - <?=($patient_info_data["Last_Visit_Date"] != "")?date('d-m-Y',strtotime($patient_info_data["Last_Visit_Date"])):''?>
                </address>
            </div>
            </div>
        </div>
    </div>
    <?php
}
?>