<?php
class Database {
    // Mengelola koneksi ke database menggunakan PDO

    private $host;
    private $db_name;
    private $user;
    private $password;
    private $conn;

    public function __construct() {
        $config = require_once __DIR__."/../config/database.php";

        $this->host = $config['host'];
        $this->db_name = $config['db_name'];
        $this->user = $config['user'];
        $this->password = $config['password'];
    }

    public function connect() {
        $this->conn = new PDO (
            "mysql:host={$this->host};dbname={$this->db_name}",
            $this->user,
            $this->password
        );
        return $this->conn;
    }
}
