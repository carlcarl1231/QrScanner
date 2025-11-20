<?php

require_once "Dbh.php";

class Login extends Dbh {

    private $username;
    private $password;
    private $status;

    public function __construct($username, $password, $status = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    /**
     * Insert user (admin or regular user)
     */
    public function insertUser()
    {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        if ($this->isAdmin()) {
            return $this->insertAdmin($hashedPassword);
        }

        return $this->insertNormalUser($hashedPassword);
    }

    /**
     * Check if user is admin
     */
    private function isAdmin()
    {
        return strtolower($this->status) === 'admin';
    }

    /**
     * Insert admin record
     */
    private function insertAdmin($hashedPassword)
    {
        $query = "INSERT INTO admin_tb (username, password, status)
                  VALUES (:username, :password, :status)";

        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

    /**
     * Insert normal user record
     */
    private function insertNormalUser($hashedPassword)
    {
        $query = "INSERT INTO user_tb (username, password)
                  VALUES (:username, :password)";

        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $hashedPassword);

        return $stmt->execute();
    }
}

?>
