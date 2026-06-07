<?php
class Database {
    private $host     = 'localhost';
    private $db_name  = 'db_siswa';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->db_name
            );
            $this->conn->set_charset('utf8mb4');
            if ($this->conn->connect_error) {
                throw new Exception('Koneksi gagal: ' . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
        return $this->conn;
    }
}
