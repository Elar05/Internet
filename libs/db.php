<?php

class DB {

    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;

    public function __construct() {
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->pass = constant('PASS');
        $this->charset = constant('CHARSET');
    }

    function connect() {
        try {
            $con = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  => false
            ];
            
            $pdo = new PDO($con, $this->user, $this->pass, $options);

            return $pdo;
        } catch (PDOException $e) {
            print_r("Error en conexion" . $e->getMessage());
        }
    }

}