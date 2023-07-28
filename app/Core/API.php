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
    public function __construct()
    {
        self::$status = false;
    }
    public function API()
    {
        return array();

    }
    public function executeAPI()
    {
        try {
            if (self::verifyParamsAction()) {
                echo "si hay accion<br>";
                //verifico si hay accion
                $dataAPI = $this->API();
                self::$log = $dataAPI['log'];
                echo "API log ".self::$log." <br>";
                if ($dataAPI['status']) {
                    self::$status = true;
                    self::$data = $dataAPI['data'];
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
        echo "ssss. ".self::$log.". <br><br>";
        echo json_encode(array('status' => self::$status, 'data' => self::$data, 'log' => self::$log));
    }

}