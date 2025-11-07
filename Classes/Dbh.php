<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;


class Dbh {
    private $host;
    private $dbname;
    private $dbusername;
    private $dbpassword;

    public function __construct() {
        $dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->dbusername = $_ENV['DB_USER'];
        $this->dbpassword = $_ENV['DB_PASS'];
    }

   
    public function connect() {
        try{
            $pdo = new PDO("mysql:host=". $this->host . ";dbname=" 
            . $this->dbname, $this->dbusername, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch(PDOException $e) {
            die("Connection Failed: ". $e->getMessage());
        }
    }   

}