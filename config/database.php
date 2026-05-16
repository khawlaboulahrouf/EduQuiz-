<?php
class Database {

    private $host = "localhost";
    private $dbname = "eduquiz";
    private $username = "root";
    private $password = "";

    public static function getConnection() {
        try {
            $pdo = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                self::$username,
                self::$password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        } catch(PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }
}
?>

 
