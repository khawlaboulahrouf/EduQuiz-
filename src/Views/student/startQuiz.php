<?php
class Quiz {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function checkCode($code) {

        $sql = "SELECT * FROM quizzes WHERE quiz_code = :code LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':code', $code);

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }
}
?>