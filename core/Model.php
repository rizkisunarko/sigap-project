<?php
require_once "Database.php";

class Model {
    // Base class untuk semua model yang berhubungan dengan DB

    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }
}
