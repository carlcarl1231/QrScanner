<?php
require_once 'Dbh.php';

class User extends Dbh {

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

    public function addUser($fName,$lName,$mi,$plateNumber,$type,$contactNumber,$orcr) {
        $sql = "INSERT INTO table_scan (fName, lName, mi, plateNumber, vehicleType, address, contactNumber, orcr)
                VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fName,$lName,$mi,$plateNumber,$type,$contactNumber,$orcr]);

        return $this->connect()->lastInsertId();
    }


    public function getUser($id) {
        $sql = "SELECT * FROM scan_table where id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}