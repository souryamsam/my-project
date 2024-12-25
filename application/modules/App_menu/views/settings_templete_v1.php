<div class="row">
    <?php
    if (!empty($menu_data)) {
        foreach ($menu_data as $mrow) {
            ?>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-cog fa-spin" aria-hidden="true"></i><span class="h6"><?= $mrow['MENU_NAME'] ?></span>
                    </div>
                    <div class="box-body">
                        <ul style="list-style: none;padding-left: 5px;">

                            <?php
                            if (!empty($mrow['MENU_PAGES'])) {
                                foreach ($mrow['MENU_PAGES'] as $row) {
                                    ?>

                                    <li class="p-1"><a href="<?= $row['PAGE_NAME'] ?>"><i class="<?= $row['ICON'] ?>" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?= $row['PAGE_APP_NAME'] ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>