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
        self::setErrorHandler();
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
                    self::$log = get_config('api-success', 't');
                } else {
                    throw new Exception(self::$log);
                }
            } else {
                throw new Exception(get_config('action-not-set', 't'));
            }
        } catch (Exception $e) {
            self::logError($e->getMessage());
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
        $json_response = json_encode(array('status' => self::$status, 'data' => self::$data, 'log' => self::$log));
        header('Content-Type: application/json');
        echo $json_response;
    }

    protected static function setErrorHandler()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            $message = "Error: $errstr in $errfile on line $errline";
            self::logError($message);
        });

        set_exception_handler(function ($exception) {
            $message = $exception->getMessage();
            self::logError($message);
        });
    }

    protected static function logError($message = 'An error occurred.')
    {
        // Aquí puedes implementar la lógica para guardar el mensaje de error en un archivo de log,
        // en una base de datos o realizar cualquier acción que desees.
        // Por ahora, simplemente devolvemos el mensaje de error para que se incluya en el resultado JSON.
        // Puedes personalizar esta función según tus necesidades.
        self::$log = $message;
    }
}