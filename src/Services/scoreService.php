<?php

declare(strict_types=1);

// ============================================================
//  SERVICE : ScoreService
//  Logique métier : calcul du score + sauvegarde en BDD
//  Axe 4 — Correction & Statistiques
// ============================================================

require_once __DIR__ . '/../Repositories/resultRepo.php';

class ScoreService
{
    private ResultRepository $resultRepo;

    public function __construct()
    {
        $this->resultRepo = new ResultRepository();
    }

    // ----------------------------------------------------------
    //  CALCULER et SAUVEGARDER le score d'un étudiant
    //
    //  $submittedAnswers : tableau des réponses soumises
    //    Format : [ question_id => answer_id , ... ]
    //             ex : [1 => 3, 2 => 7, 3 => 9]
    //
    //  $correctAnswers : tableau des bonnes réponses (depuis BDD)
    //    Format : [ question_id => answer_id , ... ]
    //
    //  Retourne : le score sur 100
    // ----------------------------------------------------------
    public function calculateAndSave(
        int   $userId,
        int   $quizId,
        array $submittedAnswers,
        array $correctAnswers
    ): int {
        // Nombre total de questions
        $total = count($correctAnswers);

        if ($total === 0) {
            return 0; // Sécurité : quiz vide
        }

        // Compter les bonnes réponses
        $correct = 0;
        foreach ($correctAnswers as $questionId => $correctAnswerId) {
            // L'étudiant a-t-il répondu à cette question ?
            if (isset($submittedAnswers[$questionId])) {
                // Sa réponse est-elle correcte ?
                if ((int)$submittedAnswers[$questionId] === (int)$correctAnswerId) {
                    $correct++;
                }
            }
        }

        // Score sur 100 (arrondi)
        $score = (int)round(($correct / $total) * 100);

        // Sauvegarder en base de données
        $this->resultRepo->save($userId, $quizId, $score);

        return $score;
    }

    // ----------------------------------------------------------
    //  RÉCUPÉRER les bonnes réponses d'un quiz depuis la BDD
    //  Retourne : [ question_id => correct_answer_id ]
    // ----------------------------------------------------------
    public function getCorrectAnswers(int $quizId): array
    {
        // On utilise directement la connexion PDO
        $database = new Database();
        $db       = $database->connect();

        $sql = "SELECT q.id AS question_id, a.id AS answer_id
                FROM questions q
                JOIN answers a ON a.question_id = q.id
                WHERE q.quiz_id  = :quiz_id
                  AND a.is_correct = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([':quiz_id' => $quizId]);

        $correctAnswers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $correctAnswers[(int)$row['question_id']] = (int)$row['answer_id'];
        }

        return $correctAnswers;
    }

    // ----------------------------------------------------------
    //  STATISTIQUES pour le tableau de bord formateur
    //  Retourne un tableau avec : moyenne, meilleur, moins bon
    // ----------------------------------------------------------
    public function getQuizStats(array $results): array
    {
        if (empty($results)) {
            return ['average' => 0, 'best' => 0, 'worst' => 0, 'count' => 0];
        }

        $scores = array_map(fn(Result $r) => $r->getScore(), $results);

        return [
            'count'   => count($scores),
            'average' => (int)round(array_sum($scores) / count($scores)),
            'best'    => max($scores),
            'worst'   => min($scores),
        ];
    }
}
