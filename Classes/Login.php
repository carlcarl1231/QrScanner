<?php

require_once "Dbh.php";

class Login extends Dbh {

private $username;
private $password;
private $status;

public function __construct($username, $password, $status=null)
{

    $this->username=$username;
    $this->password=$password;
    $this->status=$status;

}

public function insertUser() {

    $hashedPassword=password_hash($this->password, PASSWORD_DEFAULT);

 if ($this->status === 'admin') {
        $query = "INSERT INTO admintb('username', 'password', 'status') VALUES (:username,:password,:status)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":password",$hashedPassword);
        $stmt->bindParam(":status",$this->status);
        $stmt->execute();
 } else {
        $query = "INSERT INTO admintb('username', 'password') VALUES (:username,:password)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":password",$hashedPassword);
        $stmt->execute();
 }
}
    
    
}



?>