<?php
require_once __DIR__ . '/../config/Database.php';

class Siswa {
    private $conn;
    private $table = 'siswa';

    public $id;
    public $nis;
    public $nama;
    public $jenis_kelamin;
    public $kelas;
    public $alamat;
    public $no_telepon;
    public $email;
    public $tanggal_masuk;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // READ ALL
    public function getAll($search = '') {
        if ($search) {
            $search = '%' . $this->conn->real_escape_string($search) . '%';
            $sql = "SELECT * FROM {$this->table}
                    WHERE nama LIKE '{$search}'
                       OR nis  LIKE '{$search}'
                       OR kelas LIKE '{$search}'
                    ORDER BY id DESC";
        } else {
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        }
        $result = $this->conn->query($sql);
        return $result;
    }

    // READ ONE
    public function getById($id) {
        $id  = (int)$id;
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    // CREATE
    public function create() {
        $nis            = $this->conn->real_escape_string($this->nis);
        $nama           = $this->conn->real_escape_string($this->nama);
        $jenis_kelamin  = $this->conn->real_escape_string($this->jenis_kelamin);
        $kelas          = $this->conn->real_escape_string($this->kelas);
        $alamat         = $this->conn->real_escape_string($this->alamat);
        $no_telepon     = $this->conn->real_escape_string($this->no_telepon);
        $email          = $this->conn->real_escape_string($this->email);
        $tanggal_masuk  = $this->conn->real_escape_string($this->tanggal_masuk);

        $sql = "INSERT INTO {$this->table}
                    (nis, nama, jenis_kelamin, kelas, alamat, no_telepon, email, tanggal_masuk)
                VALUES
                    ('{$nis}', '{$nama}', '{$jenis_kelamin}', '{$kelas}',
                     '{$alamat}', '{$no_telepon}', '{$email}', '{$tanggal_masuk}')";

        return $this->conn->query($sql);
    }

    // UPDATE
    public function update() {
        $id             = (int)$this->id;
        $nis            = $this->conn->real_escape_string($this->nis);
        $nama           = $this->conn->real_escape_string($this->nama);
        $jenis_kelamin  = $this->conn->real_escape_string($this->jenis_kelamin);
        $kelas          = $this->conn->real_escape_string($this->kelas);
        $alamat         = $this->conn->real_escape_string($this->alamat);
        $no_telepon     = $this->conn->real_escape_string($this->no_telepon);
        $email          = $this->conn->real_escape_string($this->email);
        $tanggal_masuk  = $this->conn->real_escape_string($this->tanggal_masuk);

        $sql = "UPDATE {$this->table} SET
                    nis            = '{$nis}',
                    nama           = '{$nama}',
                    jenis_kelamin  = '{$jenis_kelamin}',
                    kelas          = '{$kelas}',
                    alamat         = '{$alamat}',
                    no_telepon     = '{$no_telepon}',
                    email          = '{$email}',
                    tanggal_masuk  = '{$tanggal_masuk}'
                WHERE id = {$id}";

        return $this->conn->query($sql);
    }

    // DELETE
    public function delete($id) {
        $id  = (int)$id;
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        return $this->conn->query($sql);
    }

    // COUNT
    public function count() {
        $sql    = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->conn->query($sql);
        $row    = $result->fetch_assoc();
        return $row['total'];
    }

    // NIS sudah ada?
    public function nisExists($nis, $excludeId = null) {
        $nis = $this->conn->real_escape_string($nis);
        $sql = "SELECT id FROM {$this->table} WHERE nis = '{$nis}'";
        if ($excludeId) {
            $sql .= " AND id != " . (int)$excludeId;
        }
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }
}
