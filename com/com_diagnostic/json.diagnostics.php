<?php
include('../../init.php');

use App\Models\Diagnostico;

$mDiag = new Diagnostico;
$term = $_REQUEST['term'] ?? null;
