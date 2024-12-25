<?php
$menus = $this->menu->Accessmenus('RMID');
$row_count = 0;
$numOfCols = 4;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="row">
    <?php
        if(!empty($menus)) {
            foreach($menus as $menu) {
    ?>
        <div class="col-md-<?=$bootstrapColWidth?>">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa <?=$menu['MENU_ICON']?>"></i>&nbsp;&nbsp<?=$menu['MENU_NAME']?>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-striped table-hover" style="overflow-y:scroll">
                            <tbody>
                                <?php
                                    $mid_pages = $this->menu->getPagesrespectToMenu($menu['MENU_ID']);
                                    foreach($mid_pages as $pages) {
                                ?>
                                    <tr>
                                        <td style="width:5%"> <i class="fa <?=$pages['MENU_ICON']?>"></i></td>
                                        <td><a href="<?=$pages['PAGE_URL']?>"><?=$pages['PAGE_NAME']?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $row_count++;
        if($row_count % $numOfCols == 0) echo '</div><div class="row">';                                    
            }
        }
    ?>
</div>