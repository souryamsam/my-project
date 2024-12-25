<?php
$menus = $this->menu->Accessmenus('BOTTOM');
$row_count = 0;
$numOfCols = 4;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="container-fluid">
    <div class="row">
        <?php
            if(!empty($menus)) {
                foreach($menus as $menu) {
        ?>
            <div class="col-md-<?=$bootstrapColWidth?>">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa <?=$menu['MENU_ICON']?>"></i> <?=$menu['MENU_NAME']?></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-hover table-sm">
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
</div>