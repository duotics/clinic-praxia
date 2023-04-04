<?php

namespace App\Core;

abstract class genInterface
{
    protected $obj;
    protected $vP;
    protected $log;

    public function showInterface()
    {
        $resfin = $this->obj;
        if ($resfin['est'] == true) {
            $ret = $resfin['val'];
        } else {
            $ret = $resfin['log'];
        }
        echo $ret;
    }
}
