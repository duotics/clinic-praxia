<?php

namespace App\Core;

use Exception;

class genInterfaceHead extends genInterface
{
    public function __construct(protected $title = null, protected $css = null, protected $js = null, protected $jsHead = null, protected $jsBody = null, protected $jsFoot = null)
    {
        if (!isset($this->title)) {
            $this->title = $_ENV["APP_NAME"];
        }
        $this->gen_head();
    }
    private function gen_head()
    {
        try {
            $obj = null;
            $obj .= '<!DOCTYPE html>';
            $obj .= '<html>';
            $obj .= '<head>';
            $obj .= '<meta charset="UTF-8">';
            $obj .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
            $obj .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            $obj .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $obj .= '<title>' . $this->title . '</title>';
            $obj .= '<meta name="author" content="' . $_ENV["APP_AUTHOR"] . '">';
            $obj .= '<meta name="description" content="' . $_ENV["APP_DESC"] . '">';
            $obj .= '<link rel="shortcut icon" href="' . route['a'] . 'favicon.ico" type="image/x-icon">';
            $obj .= '<link rel="icon" href="' . route['a'] . 'favicon.ico" type="image/x-icon">';
            $obj .= '</head>';
            if (isset($this->css['body-bg'])) {
                $obj .= '<style>';
                $obj .= '.body-login {';
                $obj .= 'background-image: url("' . route['i'] . $this->css['body-bg'] . '");';
                $obj .= 'background-repeat: no-repeat;';
                $obj .= 'background-attachment: fixed;';
                $obj .= 'background-size: cover;';
                $obj .= '}';
                $obj .= '</style>';
            }
            $obj .= '<body class="' . ($this->css['body'] ?? null) . '">';
            $this->vP = TRUE;
            $this->obj = $obj;
        } catch (Exception $e) {
            $this->vP = FALSE;
        }
    }
}
