<?php
# Type="MYSQL"
# HTTP="true"
$hostname_conn = $_SERVER['DB_SERVER'];
$database_conn = $_SERVER['DB_BASE'];
$username_conn = $_SERVER['DB_USER'];
$password_conn = $_SERVER['DB_PASS'];

if (!isset($conn)) {
    $conn = mysqli_connect($hostname_conn, $username_conn, $password_conn, $database_conn) or trigger_error(mysqli_error($conn), E_USER_ERROR);
    //mysqli_select_db($conn, $database_conn);
    mysqli_query($conn, "SET NAMES 'utf8'");
    define("conn", $conn);
}
