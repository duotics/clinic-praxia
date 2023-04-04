<?php
$param1=$_REQUEST['name'];
$param2=$_REQUEST['time'];
$val1=$param1."-John";
$val2=$param2."-2pm";
echo json_encode( array( "name"=>$val1,"time"=>$val2 ) ); ?>