<?php

require_once __DIR__ . '/../Services/QuizService.php';
require_once __DIR__ . '/../Services/QuestionService.php';

class TeacherController
{

    private QuizService $quizService;
    private QuestionService $questionService;

    public function __construct()
    {
        $this->quizService = new QuizService();
        $this->questionService = new QuestionService();
    }

    public function dashboard()
    {

        $quizzes = $this->quizService->getTeacherQuizzes(1);

        require __DIR__ . '/../Views/dashboard/dashboard.php';
    }

    public function createQuiz()
    {

        if ($_POST) {

            $this->quizService->createQuiz(
                $_POST['title'],
                $_POST['description'],
                1
            );

            header("Location: index.php?action=dashboard");
            exit;
        }

        require __DIR__ . '/../Views/quiz/creatQuiz.php';
    }

    public function addQuestion()
    {

        $quizId = $_GET['quiz_id'];

        if ($_POST) {

            $questionText = $_POST['question'];

            $answers = [
                $_POST['a1'],
                $_POST['a2'],
                $_POST['a3'],
                $_POST['a4']
            ];

            $correctIndex = $_POST['correct'];

            $this->questionService->addQuestion(
                $quizId,
                $questionText,
                $answers,
                $correctIndex
            );

            
header("Location: index.php?action=listQuestions&quiz_id=" . $quizId);
exit;
        }

        require __DIR__ . '/../Views/quiz/addQuestion.php';
    }

    public function deleteQuestion()
{
    if (!isset($_GET['id'])) {
        die("id missing");
    }

    $questionId = (int) $_GET['id'];

    $this->questionService->deleteQuestion($questionId);

    header("Location: index.php?action=listQuestions&quiz_id=" . $_GET['quiz_id']);
    exit;
}

    public function editQuestion()
    {
        echo "editQuestion OK";
    }
    public function listQuestions()
{
    if (!isset($_GET['quiz_id'])) {
        die("quiz_id missing");
    }

    $quizId = $_GET['quiz_id'];

    $questions = $this->questionService->getQuestionsWithAnswers($quizId);

    require __DIR__ . '/../Views/dashboard/listQuestion.php';
}
}
