<?php

namespace App\Core;

use Exception;

abstract class genInterface
{
    protected $obj;
    protected $vP;
    protected $log;

    public function showInterface()
    {
        if ($this->vP == true) {
            echo $this->obj;
        } else {
            echo $this->log;
        }
    }
}
