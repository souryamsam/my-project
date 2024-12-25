<?php
if($this->session->userdata("user_status")) {
    $fav_pages = $this->session->userdata("fav_pages");
    ?>
    <div class="modal fade" id="MpageList">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="border-radius:7px;">
                <div class="modal-header">
                    <a href="<?=base_url("logout")?>" class="close text-red">&times;</a>
                    <div class="text-center contentbox center-block">
                        <h3 class="modal-title">Choose your favourite Dashboard</h3>
                    </div>
                </div>
                <?=form_open(base_url('User/save_favorite_pages'),array("class"=>"fav_page_form","id"=>"fav_page_form","autocomplete"=>"off"))?>
                <div class="modal-body">
                    <fieldset class="checkbox-group">
                        <?php
                        if(!empty($fav_pages)) {
                            foreach($fav_pages as $row) {
                            ?>
                            <div class="checkbox">
                                <label class="checkbox-wrapper">
                                    <input type="radio" class="checkbox-input rdb_pages" id="rdb_pages<?=$this->my_encryption->encrypt($row["PAGE_ID"])?>" name="rdb_pages" value="<?=$this->my_encryption->encrypt($row["PAGE_ID"])?>"/>
                                    <span class="checkbox-tile">
                                        <span class="checkbox-icon">
                                            <i class="<?=$row["ICON"]?> fa-lg" style="color:<?=$row["ICON_COLOR"]?>;"></i>
                                        </span>
                                        <span class="checkbox-label"><?=str_replace('Dashboard','',$row["PAGE_APP_NAME"])?></span>
                                    </span>
                                </label>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10">
                            <button type="submit" class="btn btn-success btn-block btn-flat"><i class="fa fa-save"></i> Save</button> 
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
<script>
    $(function() {
        $("#MpageList").modal("show");
        $("#fav_page_form").submit(function(){
            var checked_fav_page = $(".rdb_pages:checked").length;
            if(checked_fav_page > 0) {
                if(patient_tbl_len > 0) {
                return true;
                }
                else{
                return false;
                }
            }
            else{
                return false;
            }
        })
    })
    </script>
<?php
}
?>