<?php include('../../init.php');
//echo changeDateEnglishToSpanish();

$dateFormat->setPattern('EEEE, d MMMM y');
echo $dateFormat->format(new DateTime());
