<?php
function dep($data, $tit = null)
{
    $date = date('Y-m-d H:i:s');
    $format = print_r("<div><small>* BEG Debug [{$tit}] > $date | -> ");
    if (isset($data)) {
        $format .= print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
    } else
        $format .= print_r(' *null* ');
    $format = print_r("<- | END Debug ></small></div>");
    return $format;
}

function get_config($string, $section)
{
    return (isset(cfg[$section][$string])) ? cfg[$section][$string] : "{{{$section}}}";

}

function removeSpecialChars(string $texto): string
{
    return preg_replace('/[^a-zA-Z0-9]/', '', $texto);
}

if (!function_exists('startConfigs')) {
    function startConfigs($name)
    {
        $ret = null;
        if (!isset($_SESSION[$name])) {
            $conf = parse_ini_file(root['o'] . "{$name}.ini", TRUE);
            foreach ($conf as $x => $xval) {
                foreach ($xval as $y => $yval)
                    $configEnd[$x][$y] = $yval;
            }
            $_SESSION[$name] = $configEnd;
            $ret = $configEnd;
        } else {
            $ret = $_SESSION[$name];
        }
        return $ret;
    }
}

function getBSTheme()
{
    return $_SESSION['dU']['THEME'] ?? $_ENV["APP_THEME"] ?? "zephyre";
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
    $imgRet['n'] = route['i'] . cfg['sys']['noimage']; //'images/struct/no_image.jpg';
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
            if ($key != 'tip')
                $paramCode = ' ' . $key . ' = ' . '"' . $valor . '"';
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
    if (!in_array($ext, $params['ext']))
        $LOG .= '<h4>Archivo no valido</h4>';
    else { // Verifica el tamaño maximo
        if (filesize($file['tmp_name']) > $params['siz'])
            $LOG .= '<h4>Archivo Demasiado Grande :: maximo ' . ($params['siz'] / 1024 / 1024) . ' MB</h4>';
        else { // Verifica Permisos de Carpeta, Si Carpeta Existe.
            if (!is_writable($params['pat']))
                $LOG .= '<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>';
            else { // Mueve el archivo a su lugar correpondiente.
                if (!move_uploaded_file($file['tmp_name'], $params['pat'] . $filename))
                    $LOG .= '<h4>Error al Cargar el Archivo</h4>';
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