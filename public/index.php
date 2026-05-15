<?php

require_once __DIR__ . '../../src/Controllers/TeacherController.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$controller = new TeacherController();

$action = $_GET['action'] ?? 'dashboard';

if ($action === 'dashboard') $controller->dashboard();
elseif ($action === 'createQuiz') $controller->createQuiz();
elseif ($action === 'addQuestion') $controller->addQuestion();
elseif ($action === 'deleteQuestion') $controller->deleteQuestion();
elseif ($action === 'editQuestion') $controller->editQuestion();
elseif ($action === 'listQuestions') $controller->listQuestions();
else echo "Unknown action: " . $action;