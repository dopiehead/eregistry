<?php

declare(strict_types=1); 

class Database {
    private string $host = "localhost";
    private string $dbname = "eregistry";
    private string $username = "root";
    private string $password = "";
    public mysqli $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
