<?php

class Answer {

    private string $answer;
    private bool $isCorrect;
    private int $questionId;

    public function __construct($answer, $isCorrect, $questionId) {
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
        $this->questionId = $questionId;
    }

    public function getAnswer() { return $this->answer; }
    public function getIsCorrect() { return $this->isCorrect; }
    public function getQuestionId() { return $this->questionId; }
}