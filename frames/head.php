<?php

use App\Core\genInterfaceHead;

$mHead = new genInterfaceHead($title ?? null, $css ?? null);

$mHead->showInterface();
?>
<?php include(root['s'] . 'styles.php'); ?>
<?php include(root['s'] . 'libs.php'); ?>