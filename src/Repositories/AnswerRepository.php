<?php

require_once __DIR__ . '/../../config/Database.php';

class AnswerRepository
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function create($questionId, $answer, $isCorrect)
    {

        $stmt = $this->conn->prepare(
            "INSERT INTO answers(answer, is_correct, question_id)
             VALUES(?, ?, ?)"
        );

        return $stmt->execute([$answer, $isCorrect, $questionId]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function deleteByQuestion($questionId)
    {
        $sql = "DELETE FROM answers WHERE question_id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$questionId]);
    }
    public function getByQuestion($questionId)
    {
        $sql = "SELECT * FROM answers WHERE question_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$questionId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
