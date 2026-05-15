<?php

require_once __DIR__ . '../../Repositories/quizRepo.php';
require_once __DIR__ . '/../Entities/quiz.php';

class QuizService {

    private QuizRepository $repo;

    public function __construct() {
        $this->repo = new QuizRepository();
    }

    public function createQuiz($title, $description, $userId) {

        $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        $quiz = new Quiz($title, $description, $code, $userId);

        return $this->repo->create($quiz);
    }

    public function getTeacherQuizzes($userId) {
        return $this->repo->getByTeacher($userId);
    }
}