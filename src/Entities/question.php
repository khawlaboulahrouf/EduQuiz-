<?php

class Question {

    private string $question;
    private int $quizId;

    public function __construct($question, $quizId) {
        $this->question = $question;
        $this->quizId = $quizId;
    }

    public function getQuestion() { return $this->question; }
    public function getQuizId() { return $this->quizId; }
}