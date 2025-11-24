<?php
require_once 'Dbh.php';

class Login extends Dbh {
    private $username;
    private $password;
    private $status;

    public function __construct($username, $password, $status = null) {
        parent::__construct(); // load DB
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
            $stmt->execute([
                ':username' => $this->username,
                ':password' => $hashedPassword,
                ':status' => $this->status
            ]);
        } else {
            $query = "INSERT INTO user_tb (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':username' => $this->username,
                ':password' => $hashedPassword
            ]);
        }
    }

    public function loginuser() {
       if ($this->status === 'admin') {
            $query = "SELECT username AND password FROM admin_tb WHERE username = :username LIMIT 1";
            $stmt = $this->connection()->prepare($query);
            $stmt->bindParam(':username', $this->username);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $inputPass = hash('sha256', $this->password);

                if (password_verify($this->password, $row['password'])) {
                    return [
                        'status' => 'success', 'username' => $row['username'] ]; }
            }

            return ['status' => 'failed'];
       }else {  
     
            $query = "SELECT username AND password FROM user_tb WHERE username = :username LIMIT 1";
            $stmt = $this->connection()->prepare($query);
            $stmt->bindParam(':username', $this->username);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $inputPass = hash('sha256', $this->password);

                if (password_verify($this->password, $row['password'])) {
                    return [
                        'status' => 'success',
                        'username' => $row['username']
                    ];
                }
            }

            return ['status' => 'failed'];
    
    }

}
public function get_user() {
    if ($this->status === 'admin') {
        $query = "SELECT * FROM admin_tb";
        $stmt = $this->connection()->prepare($query);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    } else {
        $query = "SELECT * FROM user_tb";
        $stmt = $this->connection()->prepare($query);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;

    }
}

public function delete_user($id) {
    if ($this->status === 'admin') {
        $query = "DELETE FROM admin_tb WHERE id = :id LIMIT 1 ";

        $stmt = $this->connection()->prepare($query);
        $stmt->bingParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'failed'];
        }
    } else {
        $query = "DELETE FROM admin_tb WHERE id = :id LIMIT 1 ";

        $stmt = $this->connection()->prepare($query);
        $stmt->bingParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'failed'];
        }
    }

}

}
