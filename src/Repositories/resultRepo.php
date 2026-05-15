<?php

declare(strict_types=1);

// ============================================================
//  REPOSITORY : ResultRepository
//  Toutes les requêtes SQL liées aux résultats & corrections
//  Axe 4 — Correction & Statistiques
// ============================================================

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Entities/result.php';

class ResultRepository
{
    private PDO $db;

    public function __construct()
    {
        // On récupère la connexion PDO depuis la classe Database du groupe
        $database   = new Database();
        $this->db   = $database->connect();
    }

    // ----------------------------------------------------------
    //  1. SAUVEGARDER un résultat après soumission du quiz
    // ----------------------------------------------------------
    public function save(int $userId, int $quizId, int $score): bool
    {
        $sql  = "INSERT INTO results (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':quiz_id' => $quizId,
            ':score'   => $score,
        ]);
    }

    // ----------------------------------------------------------
    //  2. RÉCUPÉRER le résultat d'un étudiant pour un quiz
    //     (utilisé sur la page de correction de l'étudiant)
    // ----------------------------------------------------------
    public function findByUserAndQuiz(int $userId, int $quizId): ?Result
    {
        $sql = "SELECT r.*, u.name AS student_name, q.title AS quiz_title
                FROM results r
                JOIN users   u ON u.id = r.user_id
                JOIN quizzes q ON q.id = r.quiz_id
                WHERE r.user_id = :user_id
                  AND r.quiz_id = :quiz_id
                ORDER BY r.created_at DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':quiz_id' => $quizId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si aucun résultat trouvé, on retourne null
        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    // ----------------------------------------------------------
    //  3. TABLEAU DE BORD FORMATEUR
    //     Tous les résultats d'un quiz, triés du meilleur au moins bon
    // ----------------------------------------------------------
    public function findAllByQuiz(int $quizId): array
    {
        $sql = "SELECT r.*, u.name AS student_name, q.title AS quiz_title
                FROM results r
                JOIN users   u ON u.id = r.user_id
                JOIN quizzes q ON q.id = r.quiz_id
                WHERE r.quiz_id = :quiz_id
                ORDER BY r.score DESC, r.created_at ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':quiz_id' => $quizId]);

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $this->hydrate($row);
        }

        return $results;
    }

    // ----------------------------------------------------------
    //  4. RÉPONSES soumises par un étudiant pour un quiz
    //     (pour afficher la correction question par question)
    // ----------------------------------------------------------
    public function findStudentAnswers(int $userId, int $quizId): array
    {
        // On récupère les réponses choisies par l'étudiant
        // Note : la table student_answers doit être créée par le groupe Axe 3
        // Structure attendue : student_answers(user_id, quiz_id, question_id, answer_id)
        $sql = "SELECT
                    q.id         AS question_id,
                    q.question   AS question_text,
                    a.id         AS chosen_answer_id,
                    a.answer     AS chosen_answer_text,
                    a.is_correct AS is_correct,
                    correct_a.answer AS correct_answer_text
                FROM student_answers sa
                JOIN questions q ON q.id = sa.question_id
                JOIN answers   a ON a.id = sa.answer_id
                -- Sous-requête pour retrouver la bonne réponse
                JOIN answers correct_a
                    ON correct_a.question_id = q.id
                    AND correct_a.is_correct = 1
                WHERE sa.user_id = :user_id
                  AND sa.quiz_id = :quiz_id
                ORDER BY q.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':quiz_id' => $quizId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------------------------------------
    //  HELPER PRIVÉ : transformer un tableau BDD → objet Result
    // ----------------------------------------------------------
    private function hydrate(array $row): Result
    {
        $result = new Result(
            userId:    (int)$row['user_id'],
            quizId:    (int)$row['quiz_id'],
            score:     (int)$row['score'],
            createdAt: $row['created_at'] ?? '',
            id:        (int)$row['id']
        );

        // Infos supplémentaires issues du JOIN
        $result->setStudentName($row['student_name'] ?? '');
        $result->setQuizTitle($row['quiz_title']     ?? '');

        return $result;
    }
}
