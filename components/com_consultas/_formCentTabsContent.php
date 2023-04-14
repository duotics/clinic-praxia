<?php
$list = $objCon->getobjNavTab();
$tabAct = $objCon->getTabAct();
if ($list) : ?>
    <div class='tab-content card card-body mt-2' id='v-pills-tabContent'>
        <?php foreach ($list as $dList) :
            $cssActive = ($tabAct == $dList['id']) ? "active" : null;
        ?>
            <div class='tab-pane fade show <?php echo $cssActive ?>' id='<?php echo $dList['id'] ?>' role='tabpanel' tabindex='0'>
                <?php include($dList['include']) ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif ?>