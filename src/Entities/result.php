<?php

declare(strict_types=1);

// ============================================================
//  ENTITÉ : Result
//  Représente un résultat de quiz (un enregistrement en BDD)
//  Axe 4 — Correction & Statistiques
// ============================================================

class Result
{
    // --- Propriétés privées (Encapsulation) ---
    private int    $id;
    private int    $userId;
    private int    $quizId;
    private int    $score;
    private string $createdAt;

    // --- Noms utiles pour l'affichage (hydratés depuis JOIN) ---
    private string $studentName = '';
    private string $quizTitle   = '';

    // ---- Constructeur ----
    public function __construct(
        int    $userId,
        int    $quizId,
        int    $score,
        string $createdAt  = '',
        int    $id         = 0
    ) {
        $this->userId    = $userId;
        $this->quizId    = $quizId;
        $this->score     = $score;
        $this->createdAt = $createdAt;
        $this->id        = $id;
    }
    // ---- Getters ----
    public function getId():          int    { return $this->id;          }
    public function getUserId():      int    { return $this->userId;      }
    public function getQuizId():      int    { return $this->quizId;      }
    public function getScore():       int    { return $this->score;       }
    public function getCreatedAt():   string { return $this->createdAt;   }
    public function getStudentName(): string { return $this->studentName; }
    public function getQuizTitle():   string { return $this->quizTitle;   }



    
    // ---- Setters (pour l'hydratation depuis JOIN) ----
    public function setStudentName(string $name):  void { $this->studentName = $name;  }
    public function setQuizTitle(string $title):   void { $this->quizTitle   = $title; }
}
