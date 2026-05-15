<?php

class Quiz {

    private $conn;

    public function __construct($db){

        $this->conn = $db;
    }

    // get quiz by code
    public function getQuizByCode($code){

        $sql = "SELECT * FROM quizzes WHERE code = :code LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':code', $code);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // get questions
    public function getQuestions($quiz_id){

        $sql = "SELECT * FROM questions WHERE quiz_id = :quiz_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':quiz_id', $quiz_id);

        $stmt->execute();

        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($questions as &$question){

            $sql = "SELECT * FROM answers WHERE question_id = :question_id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':question_id', $question['id']);

            $stmt->execute();

            $question['answers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $questions;
    }

    // check answer
    public function checkAnswer($answer_id){

        $sql = "SELECT * FROM answers WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $answer_id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}