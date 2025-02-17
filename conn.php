<?php
// Turn on PHP error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getConnection() {
    try {
        $connection = new PDO("mysql:host=nuwebspace_db; dbname=w22011554", "w22011554", "SPc1h+7DPVQb"); // Live
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        throw new Exception("Connection error ". $e->getMessage(), 0, $e);
    }
}

// Session handling
session_start();

function loggedIn() {
    if(isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}
?>