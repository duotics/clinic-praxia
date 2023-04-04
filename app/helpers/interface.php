<?php
function genFormsInpRadio($params, $sel = null, $typ = null, $def = null, $name = null)
{ //duotics_lib -> v.0.7
    $val = null;
    $contI = 0;
    foreach ($params as $xid => $xval) {
        $actinp = null;
        if (isset($sel)) {
            if (!strcmp($sel, $xid)) $actinp .= ' checked ';
        }
        switch ($typ) {
            case 'btn-group':
                $val .= "<input class='btn-check' type='radio' name='{$name}' id='{$name}-{$xid}' value='{$xid}' {$actinp}>
				<label class='btn btn-outline-primary' for='{$name}-{$xid}'>{$xval}</label>";
                break;
            case 'inline':
                $val .= "<div class='form-check form-check-inline'>
				<input name='{$name}' class='form-check-input' type='radio' id='{$name}-inlineRadioOptions{$xid}' value='{$xid}' {$actinp}>
				<label class='form-check-label' for='{$name}-inlineRadioOptions{$xid}'>{$xval}</label></div>";
                break;
            default:
                $val .= "<label class='radio inline'><input type='radio' name='{$name}' value='{$xid}' {$actinp}>{$xval}</label>";
                break;
        }
        $contI++;
    }
    if ($contI > 0) {
        if ($typ == 'btn-group') $val = "<div class='btn-group btn-group-sm' role='group' data-toggle='buttons'>{$val}</div>";
    }
    return $val;
}
function sLOG($type = NULL, $msg_m = NULL, $msg_t = NULL, $msg_c = NULL, $msg_i = NULL)
{ //v.2.4
    //echo 'entra a SLOG<br>';
    //var_dump($_SESSION['LOG']);
    $LOG = NULL;
    $vrfVL = TRUE; //var para setear $LOG
    if ($msg_m) {
        $LOG['m'] = $msg_m;
        $LOG['t'] = $msg_t;
        $LOG['c'] = $msg_c;
        $LOG['i'] = $msg_i;
    } else {
        if (isset($_SESSION['LOG'])) $LOG = $_SESSION['LOG'];
    }
    if ($LOG) {
        if (!$LOG['c']) $LOG['c'] = 'alert-info';
        switch ($type) {
            case 'a':
                $rLog = '<div id="log">';
                $rLog .= '<div class="alert alert-dismissable ' . $LOG['c'] . '" style="margin:10px;">';
                $rLog .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                if ($LOG['t']) $rLog .= '<h3>' . $LOG['t'] . '</h3>';
                $rLog .= $LOG['m'];
                $rLog .= '</div></div>';
                break;
            case 'g':
                $rLog = '<script type="text/javascript">
				logGritter("' . $LOG['t'] . '","' . $LOG['m'] . '","' . $LOG['i'] . '");
				</script>';
                break;
            case 's':
                $vrfVL = FALSE;
                break;
            case 't':
                //echo 'case t<br>';
                $rLog = '<div class="toast" style="position: absolute; bottom: 25px; right: 25px; z-index: 999" data-delay="3000">
				<div class="toast-header">
				  <img src="' . $LOG['i'] . '" class="img-fluid img-xs rounded mr-2" alt="...">
				  <strong class="mr-auto">' . $LOG['t'] . '</strong>
				  <!--<small>11 mins ago</small>-->
				  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="toast-body">
				  ' . $LOG['m'] . '
				</div>
			  </div>';
                break;
            default:
                $rLog = '<div>' . $LOG['m'] . '</div>';
                break;
        }
        echo $rLog;
    }
    if ($vrfVL) { //TRUE unset->LOG, FALSE $_SESSION LOG -> $LOG
        unset($_SESSION['LOG']);
    } else {
        $_SESSION['LOG'] = $LOG;
    }
}
