<?php

namespace app;


use PDO;
use PDOException;

class Database {
    private $host = "mysql";
    private $database_name = "ttt-api-user";
    private $username = "treggy";
    private $password = "Moshood";

    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}