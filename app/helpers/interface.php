<?php
function vP($est, $log = null)
{
    if ($est) {
        $LOGt = cfg['p']['m-ok'];
        $LOGc = cfg['p']['c-ok'];
        $LOGi = cfg['i']['okp'];
        $LOGicon = 'success';
    } else {
        $LOGt = cfg['p']['m-fail'];
        $LOGc = cfg['p']['c-fail'];
        $LOGi = cfg['i']['failp'];
        $LOGicon = 'error';
    }
    $_SESSION['LOG']['t'] = $LOGt;
    $_SESSION['LOG']['m'] = $log;
    $_SESSION['LOG']['c'] = $LOGc;
    $_SESSION['LOG']['i'] = $LOGicon;
}

function genInterfaceBusqueda($configVar)
{
    /*
    data['type'] can be: 
        c = component to use route['c']
        i = internal to use routeM
        e or empty = null
    */
    $ret = array("data-url" => null, "data-param" => null, "btn-text" => null, "btn-css" => null);
    $data = cfgBus[$configVar] ?? null;
    if ($data) {
        if ($data['url']) {
            $dataUrlType = $data['type'] ?? null;
            switch ($dataUrlType) {
                case "c":
                    $dataUrlRoute = route['c'];
                    break;
                case "i":
                    $dataUrlRoute = routeM;
                    break;
                case "e":
                    $dataUrlRoute = null;
                    break;
                default:
                    $dataUrlRoute = null;
                    break;
            }
            $dataUrlFull = $dataUrlRoute . $data['url'];
        }
        $ret['data-url'] = $dataUrlFull ?? null;
        $ret['data-param'] = $data['param'] ?? null;
        $ret['btn-text'] = $data['tit'] ?? null;
        $ret['btn-css'] = $data['css'] ?? "light";
    }
    return $ret;
}

function getBgBodyfromConfigFile()
{
    try {
        if (!isset(cfgBg['bg'])) throw new Exception("No existe archivo de configuración de fondo");
        $val = cfgBg['bg'][array_rand(cfgBg['bg'])];
        return $val;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
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
function genFormsInpSwitch($name, $status = null, $text = null, $css = null, $opt = null)
{
    $ret = null;
    try {
        if ($name) {
            if ($status == 1) {
                $statusCheck = "checked";
                $statusVal = 1;
            } else {
                $statusCheck = "";
                $statusVal = 0;
            }
            $ret = "
            <div class='form-check form-switch'>
            <input name='{$name}' class='form-check-input {$css}' type='checkbox' role='switch' id='{$name}' {$opt} value='{$statusVal}' {$statusCheck}>
            <label class='form-check-label' for='{$name}'>{$text}</label>
            </div>
            ";
        } else throw new Exception("Error genFormsInpSwitch() param 'name' empty");
    } catch (Exception $e) {
        $ret = $e->getMessage();
    }
    return $ret;
}
function genStatus($dest, $params, $css = NULL, $icons = NULL)
{ //duotics_lib->v.4.4
    $lP = null;
    $firstP = TRUE;
    foreach ($params as $x => $xVal) {
        if ($x == 'val') {
            if (!$icons) {
                if ($xVal == 1) {
                    $xVal = 0;
                    $cssST = 'btn btn-success btn-sm';
                    if (isset($icons[1])) $txtST = $icons[1];
                    else $txtST = '<i class="fas fa-check fa-fw"></i>';
                } else {
                    $xVal = 1;
                    $cssST = 'btn btn-warning btn-sm';
                    if (isset($icons[1])) $txtST = $icons[1];
                    else $txtST = '<i class="fas fa-times fa-fw"></i>';
                }
            } else {
                foreach ($icons as $y => $yVal) {
                    if ($xVal == $yVal['id']) {
                        $cssST = $yVal['css'];
                        $txtST = $yVal['icon'];
                    }
                }
            }
        }
        if ($firstP == TRUE) {
            $lP .= '?' . $x . '=' . $xVal;
            $firstP = FALSE;
        } else $lP .= '&' . $x . '=' . $xVal;
    }
    if ($dest) $st = '<a href="' . $dest . $lP . '" class="' . $cssST . ' ' . $css . '">' . $txtST . '</a>';
    else $st = '<span class="' . $cssST . ' ' . $css . '">' . $txtST . '</span>';
    return $st;
}
if (!function_exists("sLOG")) { //v.2.0 -> duotics_lib
    function sLOG($type = NULL, $msg = NULL, $persist = 0) //duoticsLib php8 v.0.4
    {
        $LOG = NULL;
        $vrfVL = TRUE;
        if (isset($msg)) $LOG = array("m" => $msg['m'] ?? null, "t" => $msg['t'] ?? null, "i" => $msg['i'] ?? null, "l" => $msg['l'] ?? null, "c" => $msg['c'] ?? null);
        else if (isset($_SESSION['LOG'])) $LOG = array("m" => $_SESSION['LOG']['m'], "t" => $_SESSION['LOG']['t'] ?? null, "i" => $_SESSION['LOG']['i'] ?? null, "l" => $_SESSION['LOG']['l'] ?? null, "c" => $_SESSION['LOG']['c'] ?? null);
        if ($LOG) {
            if (!$LOG['c']) $LOG['c'] = 'alert-info';
            $rLog = null;
            switch ($type) {
                case 's':
                    $vrfVL = FALSE;
                    break;
                case 'a':
                    $rLog = '<div id="log">';
                    $rLog .= '<div class="alert alert-dismissable ' . $LOG['c'] . '" style="margin:10px;">';
                    $rLog .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    if ($LOG['t']) $rLog .= '<h3>' . $LOG['t'] . '</h3>';
                    $rLog .= $LOG['m'];
                    $rLog .= '</div></div>';
                    break;
                case 't':
                    $rLog = "<div class='toast-container p-3 bottom-0 end-0' id='toastPlacement'>
					<div class='toast fade show $LOG[c]' data-bs-delay='3000'>";
                    if (isset($LOG['t'])) {
                        $rLog .= "<div class='toast-header'>
						<img src='$LOG[i]' class='img-fluid img-xxs me-2' alt=''>
						<strong class='me-auto'>$LOG[t]</strong>
						<small>$LOG[l]</small>
						<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
						</div>";
                    }
                    $rLog .= "<div class='toast-body'>$LOG[m]</div>
					</div></div>";
                    break;
                case 'sw':
                    $swalParam = array(
                        'position' => "bottom-end",
                        'icon' => $LOG['i'] ?? "success",
                        'title' => $LOG['t'] ?? null,
                        'html' => $LOG['m'] ?? null,
                        'showConfirmButton' => false,
                        'timer' => $LOG['time'] ?? 5000,
                        'background' => 'white'
                    );
                    $rLog = "<script type='text/javascript'>
						Swal.fire({
                          toast: true,
                          didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                          },
						  position: '{$swalParam['position']}',
						  icon: '{$swalParam['icon']}',
						  html: \"{$swalParam['html']}\",
						  timer: '{$swalParam['timer']}',
                          showConfirmButton: '{$swalParam['showConfirmButton']}',
						  background: '{$swalParam['background']}',
                          timerProgressBar: true,
                          showClass: {
                            popup: 'animate__animated animate__fadeInUp'
                          },
                          hideClass: {
                            popup: 'animate__animated animate__fadeOutDown'
                          }
                          
                          
						});
                    </script>";
                    break;
                default:
                    $rLog = '<div>' . $LOG['m'] . '</div>';
                    break;
            }
            echo $rLog;
        }
        if (($vrfVL) && (!($persist))) unset($_SESSION['LOG']);
        else $_SESSION['LOG'] = $LOG;
    }
}
