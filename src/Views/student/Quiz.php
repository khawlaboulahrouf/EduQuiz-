<?php

class Quiz {

    private $conn;

    public function __construct($db){

        $this->conn = $db;
    }
    // save result
public function saveResult($student_name, $quiz_id, $score, $total_questions){

    $sql = "INSERT INTO results
    (student_name, quiz_id, score, total_questions)
    VALUES
    (:student_name, :quiz_id, :score, :total_questions)";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->bindParam(':score', $score);
    $stmt->bindParam(':total_questions', $total_questions);

    return $stmt->execute();
}

// get results
public function getResults(){

    $sql = "
        SELECT *
        FROM results
        ORDER BY created_at DESC
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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