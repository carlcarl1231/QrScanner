<?php
require_once 'Dbh.php';

class User extends Dbh {

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

    public function addUser($userName, $userPass) {
        $sql = "INSERT INTO user_table(userName, userPass)
                VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userName, $userPass]);

        return $this->connect()->lastInsertId();
    }


    public function getUser($id) {
        $sql = "SELECT * FROM user_table where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM user_table WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }


}