<?php
error_reporting(E_ALL);

// السماح بعرض الأخطاء
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "training_institute";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if ($params) {
            $stmt->bind_param(...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function close() {
        $this->conn->close();
    }
}
?>
