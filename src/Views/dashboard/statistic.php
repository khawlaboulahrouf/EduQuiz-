<?php

declare(strict_types=1);

// ============================================================
//  CONTRÔLEUR : Axe4Controller
//  Gère les pages de l'Axe 4 (Correction & Statistiques)
//
//  Pages gérées :
//    ?page=result          → Résultat étudiant (après soumission)
//    ?page=dashboard       → Tableau de bord formateur
//
//  À intégrer dans index.php du groupe :
//    case 'result':
//        require 'src/Controllers/Axe4Controller.php';
//        (new Axe4Controller())->showResult();
//        break;
// ============================================================

require_once __DIR__ . '/../Repositories/resultRepo.php';
require_once __DIR__ . '/../Services/ScoreService.php';

class Axe4Controller
{
    private ResultRepository $resultRepo;
    private ScoreService     $scoreService;

    public function __construct()
    {
        $this->resultRepo   = new ResultRepository();
        $this->scoreService = new ScoreService();
    }

    // ----------------------------------------------------------
    //  PAGE 1 : Résultat de l'étudiant
    //  URL : ?page=result&quiz_id=X
    //
    //  Appelée après que l'Axe 3 a soumis les réponses
    //  L'Axe 3 doit appeler ScoreService::calculateAndSave()
    //  avant de rediriger ici.
    // ----------------------------------------------------------
    public function showResult(): void
    {
        // Vérifier que l'étudiant est connecté (session gérée par Axe 1)
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $quizId = (int)($_GET['quiz_id'] ?? 0);

        // Sécurité : quiz_id obligatoire
        if ($quizId === 0) {
            header('Location: /index.php?page=dashboard');
            exit;
        }

        // Récupérer le résultat depuis la BDD
        $result = $this->resultRepo->findByUserAndQuiz($userId, $quizId);

        // Si pas de résultat, rediriger
        if ($result === null) {
            header('Location: /index.php?page=dashboard');
            exit;
        }

        // Récupérer les corrections (réponses correctes vs choisies)
        $corrections    = $this->resultRepo->findStudentAnswers($userId, $quizId);
        $totalQuestions = count($corrections);

        // Charger la vue
        require __DIR__ . '/../Views/axe4/result_student.php';
    }

    // ----------------------------------------------------------
    //  PAGE 2 : Tableau de bord formateur
    //  URL : ?page=trainer_dashboard&quiz_id=X
    //
    //  Visible uniquement pour les formateurs
    // ----------------------------------------------------------
    public function showTrainerDashboard(): void
    {
        // Vérifier que c'est bien un formateur (session Axe 1)
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'formateur') {
            header('Location: /index.php?page=login');
            exit;
        }

        $quizId = (int)($_GET['quiz_id'] ?? 0);

        if ($quizId === 0) {
            header('Location: /index.php?page=quizzes');
            exit;
        }

        // Récupérer tous les résultats du quiz
        $results    = $this->resultRepo->findAllByQuiz($quizId);

        // Calculer les statistiques globales
        $stats      = $this->scoreService->getQuizStats($results);

        // Titre du quiz (depuis le premier résultat ou une requête séparée)
        $quizTitle  = !empty($results) ? $results[0]->getQuizTitle() : "Quiz #$quizId";

        // Charger la vue
        require __DIR__ . '/../Views/axe4/dashboard_trainer.php';
    }

    // ----------------------------------------------------------
    //  ACTION : Calculer et sauvegarder le score
    //  Appelée par l'Axe 3 au moment de la soumission du quiz
    //
    //  Usage dans index.php :
    //    case 'submit_quiz':
    //        (new Axe4Controller())->submitQuiz();
    //        break;
    // ----------------------------------------------------------
    public function submitQuiz(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        $userId  = (int)$_SESSION['user_id'];
        $quizId  = (int)($_POST['quiz_id'] ?? 0);

        // $_POST['answers'] = [ question_id => answer_id ]
        // Exemple : answers[1]=3&answers[2]=7
        $submitted = $_POST['answers'] ?? [];

        // Convertir en int pour sécurité
        $submittedAnswers = [];
        foreach ($submitted as $qId => $aId) {
            $submittedAnswers[(int)$qId] = (int)$aId;
        }

        // Récupérer les bonnes réponses depuis la BDD
        $correctAnswers = $this->scoreService->getCorrectAnswers($quizId);

        // Calculer et sauvegarder le score
        $this->scoreService->calculateAndSave(
            $userId,
            $quizId,
            $submittedAnswers,
            $correctAnswers
        );

        // Rediriger vers la page de résultat
        header("Location: /index.php?page=result&quiz_id=$quizId");
        exit;
    }
}
