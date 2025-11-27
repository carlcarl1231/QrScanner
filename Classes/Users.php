<?php
require_once 'Dbh.php';

class Login extends Dbh {
    private $username;
    private $password;
    private $status;

    public function __construct($username, $password, $status = null) {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    public function insertUser() {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $pdo = $this->connect();

        if ($this->status === 'admin') {
            $query = "INSERT INTO admin_tb (username, password, status) VALUES (:username, :password, :status)";
            $stmt = $pdo->prepare($query);
            return $stmt->execute([
                ':username' => $this->username,
                ':password' => $hashedPassword,
                ':status' => $this->status
            ]);
        } else {
            $query = "INSERT INTO user_tb (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($query);
            return $stmt->execute([
                ':username' => $this->username,
                ':password' => $hashedPassword
            ]);
        }
    }

    public function loginUser() {
        $pdo = $this->connect();

        $tables = ['admin_tb', 'user_tb'];

        foreach ($tables as $table) {
            $query = "SELECT username, password FROM $table WHERE username = :username LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $this->username);
            $stmt->execute();
        }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && password_verify($this->password, $row['password'])) {
               return ['status' => 'success', 'username' => $row['username']];
        }
            return ['status' => 'failed'];
    }

    public function getUserAll() {
        $pdo = $this->connect();
        $table = ($this->status === 'admin') ? 'admin_tb' : 'user_tb';
        $stmt = $pdo->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id) {
        $pdo = $this->connect();
        $table = ($this->status === 'admin') ? 'admin_tb' : 'user_tb';
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: ['status' => 'failed'];
    }

    public function deleteUser($id) {
        $pdo = $this->connect();
        $table = ($this->status === 'admin') ? 'admin_tb' : 'user_tb';
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute() ? ['status' => 'success'] : ['status' => 'failed'];
    }
}
