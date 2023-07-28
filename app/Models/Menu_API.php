<?php

namespace App\Models;

use App\Core\API;
use App\Core\APIInterface;
use App\Models\Menu;
use Exception;

class Menu_API extends API implements APIInterface
{
    protected $model;
    public function __construct($params)
    {
        parent::setParams($params);
        $this->model = new Menu();
    }

    public function API()
    {
        $return = null;
        $log = null;
        $status = 1;
        switch (parent::$action) {
            case 'getMenuAll':
                $return = $this->model->getAllMenu();
                break;
            case 'getMenuId':
                //return $this->model->getMenuById();
                break;
            case 'getMenuItemAll':
                //return $this->model->getMenuItemAll();
                break;
            case 'getMenuItemId':
                //return $this->model->getMenuItemById();
                break;
            case 'getMenuItemByIdContainer':
                //return $this->model->getMenuItemByIdContainer();
                break;
            default:
                $status = 0;
                $log = 'Accion no encontrada'; //cfg['t']['action-not-set'];
        }
        return array('data' => $return, 'log' => $log, 'status' => $status);
    }

}