<?php
function startConfigs($file)
{
    global $root;
    $configEnd=[];
    if (!isset($_SESSION[$file])) {
        $conf = parse_ini_file($root."/config/".$file.'.ini', TRUE);
        foreach ($conf as $x => $xval) {
            foreach ($xval as $y => $yval) $configEnd[$x][$y] = $yval;
        }
    }
    return $configEnd;
}
function vP($est, $log = null)
{
    if ($est) {
        $LOGt = cfg['p']['m-ok'];
        $LOGc = cfg['p']['c-ok'];
        $LOGi = cfg['i']['okp'];
        $LOGicon = 'success';
        $LOGimg = RAIZa . cfg['p']['i-ok'];
    } else {
        $LOGt = cfg['p']['m-fail'];
        $LOGc = cfg['p']['c-fail'];
        $LOGi = cfg['i']['failp'];
        $LOGicon = 'error';
        $LOGimg = RAIZa . cfg['p']['i-fail'];
    }
    $_SESSION['LOG']['t'] = $LOGt;
    $_SESSION['LOG']['m'] = $log;
    $_SESSION['LOG']['c'] = $LOGc;
    $_SESSION['LOG']['i'] = $LOGimg;
    $_SESSION['LOG']['img'] = $LOGimg;
}

function getRealIpAddress(): string
{
    $ipAddress = '';

    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    }
    // check for IP passed from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check if multiple IP addresses exist in header
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipList as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                $ipAddress = $ip;
                break;
            }
        }
    }
    // check for remote address
    else {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    return $ipAddress;
}

function vImg($ruta, $nombre, $thumb = TRUE, $pthumb = 't_', $retHtml = [])
{ //v1.5
    //$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
    //$nombre. Nombre del Archivo
    //$thumb. TRUE o FALSE en caso de querer recuperar thumb
    //$pthumb PREFIJO de Thumb
    //RAIZ must be named RAIZ0 depends the root folder
    $imgRet['n'] = route['a'] . 'images/struct/no_image.jpg';
    $imgRet['t'] = $imgRet['n'];
    $imgRet['s'] = FALSE; //Verify if file exist is default FALSE
    if ($nombre) {
        //echo '<hr>RAIZ. '.RAIZ.$ruta.$nombre;
        //echo '<hr>$RAIZ. '.$RAIZ.$ruta.$nombre;
        if (file_exists(rootM . $ruta . $nombre)) {
            $imgRet['s'] = TRUE; //FILE EXIST RETURN TRUE AND ALL DATA (link normal, link thumb, file name original)
            $imgRet['f'] = $nombre;
            $imgRet['n'] = routeM . $ruta . $nombre;
            $imgRet['t'] = $imgRet['n'];
            if ($thumb == TRUE) {
                if (file_exists(rootM . $ruta . $pthumb . $nombre)) {
                    $imgRet['t'] = routeM . $ruta . $pthumb . $nombre;
                }
            }
        }
    }
    //Direct Return HTML Code *********** TERMINAR ESTE CODIGO
    if ($retHtml) {
        foreach ($retHtml as $key => $valor) {
            if ($key != 'tip') $paramCode = ' ' . $key . ' = ' . '"' . $valor . '"';
        }
        switch ($retHtml['tip']) {
            case 'imgn':
                $imgRet['code'] = '<img src="' . $imgRet['n'] . '" ' . $paramCode . '>';
                break;
            case 'imgt':
                $imgRet['code'] = '<img src="' . $imgRet['t'] . '" ' . $paramCode . '>';
                break;
            case 'aimg':
                $imgRet['code'] = '<a href="' . $imgRet['n'] . '" ' . $paramCode . '><img src="' . $imgRet['t'] . '"></a>';
                break;
        }
    }
    return $imgRet;
}
//uploadfile() :: Carga de Archivos al Servidor
function uploadfile($params, $file)
{
    $LOG = null;
    $code = md5(uniqid(rand()));
    $prefijo = $params['pre'] . '_' . $code;
    $fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
    $ext = substr($fileextnam, strpos($fileextnam, '.'), strlen($fileextnam) - 1); // Saca su extension
    $filename = $prefijo . $ext; // Obtiene el nombre del archivo, y su extension.
    $aux_grab = FALSE; //Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
    // Verifica si la extension es valida
    if (!in_array($ext, $params['ext'])) $LOG .= '<h4>Archivo no valido</h4>';
    else { // Verifica el tamaño maximo
        if (filesize($file['tmp_name']) > $params['siz']) $LOG .= '<h4>Archivo Demasiado Grande :: maximo ' . ($params['siz'] / 1024 / 1024) . ' MB</h4>';
        else { // Verifica Permisos de Carpeta, Si Carpeta Existe.
            if (!is_writable($params['pat'])) $LOG .= '<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>';
            else { // Mueve el archivo a su lugar correpondiente.
                if (!move_uploaded_file($file['tmp_name'], $params['pat'] . $filename)) $LOG .= '<h4>Error al Cargar el Archivo</h4>';
                else {
                    if ($params['thumb']) {
                        fnc_genthumb($params['pat'], $filename, "t_", $params['thumb-w'] ?? 100, $params['thumb-h'] ?? 100);
                    }
                    $aux_grab = TRUE;
                    $LOG .= '<p>Archivo Cargado Correctamente</p>';
                }
            }
        }
    }
    $auxres['LOG'] = $LOG;
    $auxres['EST'] = $aux_grab;
    $auxres['FILE'] = $filename;
    return $auxres;
}

//Function to prevent SQL injection
if (!function_exists("SSQL")) { //v.2.0 -> duotics_lib
    function SSQL($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    { //v.2.0
        global $conn;
        if (isset($theValue)) $theValue = mysqli_real_escape_string($conn, $theValue);
        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}
