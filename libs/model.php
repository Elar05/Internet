<?php

include_once 'libs/iModel.php';

class Model {
    
    function __construct() {
        $this->db = new DB();
    }

    function query($query) {
        return $this->db->connect()->query($query);
    }

    function prepare($query) {
        return $this->db->connect()->prepare($query);
    }

}