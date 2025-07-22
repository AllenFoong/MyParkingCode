<?php
class Database {
    private $host = "sql206.infinityfree.com";
    private $username = "if0_39517079";
    private $password = "ebooking123";
    private $database = "if0_39517079_ebooking_db";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
