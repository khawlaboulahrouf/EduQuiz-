<?php
class Database {

    private static $host = "localhost";
    private static $dbname = "EduQuiz";
    private static $username = "root";
    private static $password = "";

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