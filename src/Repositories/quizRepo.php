<?php

require_once __DIR__ . '/../../config/Database.php';

class QuizRepository {

    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create(Quiz $quiz) {

        $sql = "INSERT INTO quizzes(title, description, code, user_id)
                VALUES(?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $quiz->getTitle(),
            $quiz->getDescription(),
            $quiz->getCode(),
            $quiz->getUserId()
        ]);

        return $this->conn->lastInsertId();
    }

    public function getByTeacher($userId) {

        $stmt = $this->conn->prepare("SELECT * FROM quizzes WHERE user_id = ?");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}