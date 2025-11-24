<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

class Dbh {
    private $host;
    private $dbname;
    private $dbusername;
    private $dbpassword;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__)); // scanner/
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbname = $_ENV['DB_NAME'] ?? 'scandb';
        $this->dbusername = $_ENV['DB_USER'] ?? 'root';
        $this->dbpassword = $_ENV['DB_PASS'] ?? '';
    }

    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $pdo = new PDO($dsn, $this->dbusername, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection Failed: " . $e->getMessage());
        }
    }
}
