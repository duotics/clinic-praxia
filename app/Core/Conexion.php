<?php

namespace App\Core;

use PDO;
use PDOException;

class Conexion
{
    private static $instance = null;
    public $dbh;

    private function __construct()
    {
        $this->conn();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Conexion();
        }

        return self::$instance;
    }

    private function conn()
    {
        $servname_conn = $_ENV["DB_SERVER"];
        $servport_conn = $_ENV["DB_PORT"];
        $database_conn = $_ENV["DB_BASE"];
        $username_conn = $_ENV["DB_USER"];
        $password_conn = $_ENV["DB_PASS"];
        $charset_conn = $_ENV["DB_CHARSET"];

        $dsn_conn = "mysql:host=$servname_conn;dbname=$database_conn;port=$servport_conn;charset=$charset_conn";
        $dsn_param = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false];
        try {
            $this->dbh = new PDO($dsn_conn, $username_conn, $password_conn, $dsn_param);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->query("SET lc_time_names = 'es_ES'");
            //$ret= $this->dbh->getAttribute(PDO::ATTR_SERVER_INFO);
            //dep($ret);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
