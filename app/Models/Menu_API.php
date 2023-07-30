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
        parent::__construct($params);
        $this->model = new Menu();
    }

    public function API()
    {
        $param = parent::$params;
        $log = null;
        $status = 1;
        try {
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
                case 'getMenuItemContainer':
                    $return = $this->model->getMenuItemsByMenuContainer($param['id'] ?? null);
                    break;
                default:
                    throw new Exception(get_config('action-not-found', 't'));
            }
            return array('data' => $return ?? null, 'log' => $log ?? null, 'status' => $status);
        } catch (Exception $e) {
            return array('data' => null, 'log' => $e->getMessage(), 'status' => 0);
        }

    }

}