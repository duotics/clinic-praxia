<?php
namespace App\Core;

use Exception;

class API implements APIInterface
{
    protected static $params;
    protected static $action;
    protected static $data;
    protected static $status;
    protected static $return;
    protected static $log;
    public function __construct($params)
    {
        self::$params = $params;
        self::$status = false;
    }
    public function API()
    {
        return array();

    }
    public function executeAPI()
    {
        try {
            //verifico si hay parametro accion
            if (self::verifyParamsAction()) {
                $dataAPI = $this->API();
                self::$log = $dataAPI['log'];
                if ($dataAPI['status']) {
                    self::$status = true;
                    self::$data = $dataAPI['data'];
                    self::$log = get_config('api-success','t');
                } else {
                    throw new Exception(self::$log);
                }

            } else {
                self::$log = 'Action not set';
                throw new Exception(self::$log);
            }
        } catch (Exception $e) {
            self::$log = $e->getMessage();
        }
        self::returnData();
    }
    protected static function setParams($params)
    {
        self::$params = $params;
    }

    public static function verifyParamsAction()
    {
        if (isset(self::$params['action'])) {
            self::$action = self::$params['action'];
            return true;
        } else {
            return false;
        }
    }

    public static function returnData()
    {
        echo json_encode(array('status' => self::$status, 'data' => self::$data, 'log' => self::$log));
    }

}