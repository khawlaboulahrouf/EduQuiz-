<?php

require_once __DIR__ . '/../Repositories/questionRepo.php';
require_once __DIR__ . '/../Repositories/AnswerRepository.php';

class QuestionService
{

    private QuestionRepository $questionRepo;
    private AnswerRepository $answerRepo;

    public function __construct()
    {
        $this->questionRepo = new QuestionRepository();
        $this->answerRepo = new AnswerRepository();
    }

    public function addQuestion($quizId, $questionText, $answers, $correctIndex)
    {
        // 1. Insert question
        $questionId = $this->questionRepo->create($quizId, $questionText);

        // 2. Insert answers
        foreach ($answers as $index => $text) {

            $isCorrect = ($index == $correctIndex) ? 1 : 0;

            $this->answerRepo->create(
                $questionId,
                $text,
                $isCorrect
            );
        }

        return $questionId;
    }

    public function deleteQuestion($questionId)
{
   
    $this->answerRepo->deleteByQuestion($questionId);

    return $this->questionRepo->delete($questionId);
}

    public function updateQuestion($id, $text)
    {
        return $this->questionRepo->update($id, $text);
    }
    public function getQuestionsWithAnswers($quizId)
    {
        $questions = $this->questionRepo->getByQuiz($quizId);

        foreach ($questions as &$q) {
            $q['answers'] = $this->answerRepo->getByQuestion($q['id']);
        }

        return $questions;
    }
}
