<?php

require_once __DIR__ . '/../../config/Database.php';

class QuestionRepository
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function create($quizId, $question)
    {

        $stmt = $this->conn->prepare(
            "INSERT INTO questions(question, quiz_id) VALUES(?, ?)"
        );

        $stmt->execute([$question, $quizId]);

        return $this->conn->lastInsertId();
    }

    public function update($id, $question)
    {

        $stmt = $this->conn->prepare(
            "UPDATE questions SET question = ? WHERE id = ?"
        );

        return $stmt->execute([$question, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getByQuiz($quizId)
    {
        $sql = "SELECT * FROM questions WHERE quiz_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$quizId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
