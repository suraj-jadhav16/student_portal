<?php
/**
 * Created by PhpStorm.
 * User: Suraj Jadhav
 * Date: 10-04-2021
 * Time: 13:41
 */

class Database {
    private $_connection;
    private static $_instance; //The single instance
    private $_host     = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "student_portal";


    // Get an instance of the Database
    public static function getInstance () {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    // Constructor
    private function __construct () {
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);

        // Error handling
        if (mysqli_connect_error()) {
            throw new Exception( mysqli_connect_error());
        }

        $this->_connection->set_charset('utf8');
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone () {
        throw new Exception("Cannot clone the Database");
    }

    // Get mysqli connection
    public function getConnection () {
        return $this->_connection;
    }
}