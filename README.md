# EduQuiz - Application de Quiz en Ligne

## Description du Projet

EduQuiz est une plateforme web interne développée pour CodeAcademy permettant aux formateurs de créer rapidement des quiz en ligne et aux étudiants de passer des évaluations avec correction automatique et affichage instantané des résultats.

L’objectif principal est d’automatiser les évaluations QCM afin de réduire le temps de correction des formateurs et permettre aux étudiants de connaître immédiatement leur niveau avant de passer au module suivant.

---

# Membres du Groupe

| Nom | Responsabilité |
|---|---|
| Membre 1 | Authentification & Sécurité |
| Membre 2 | Gestion des Quiz |
| Membre 3 | Passage du Quiz |
| Membre 4 | Correction & Statistiques |

---

# Fonctionnalités Principales

## Authentification
- Inscription utilisateur
- Connexion sécurisée
- Gestion des rôles :
  - Formateur
  - Étudiant
- Gestion des sessions

---

## Gestion des Quiz
- Création de quiz
- Modification/Suppression de quiz
- Ajout de questions
- Ajout de réponses multiples
- Génération de code d’accès unique

---

## Passage des Quiz
- Accès via code quiz
- Affichage des questions
- Sélection des réponses
- Soumission des réponses

---

## Correction & Résultats
- Correction automatique
- Affichage du score
- Affichage des bonnes réponses
- Tableau de bord des résultats

---

# Technologies Utilisées

- PHP 8 (POO + Typage strict)
- MySQL
- HTML5
- Tailwind CSS
- Git & GitHub

---

# Structure du Projet

```bash
EduQuiz/
│
├── config/
│   └── Database.php
│
├── public/
│   ├── index.php
│   ├── css/
│   └── assets/
│
├── src/
│   ├── Entities/
│   ├── Repositories/
│   ├── Services/
│   └── Views/
│
├── .env
├── .gitignore
└── tailwind.config.js

🧱 Architecture du Projet

Le projet suit une architecture organisée en plusieurs couches :

Entities

Contient les objets métier :

User
Quiz
Question
Answer
Result
Repositories

Gestion des requêtes SQL et accès base de données.

Services

Contient la logique métier :

Authentification
Calcul des scores
Gestion quiz
Views

Interfaces utilisateur avec Tailwind CSS.

Base de Données
Tables Principales
users
quizzes
questions
answers
student_answers
results
🌿 Organisation Git
Branches utilisées
main
auth-feature
quiz-feature
student-feature
dashboard-feature
🚀 Installation du Projet
1️⃣ Cloner le projet
git clone <repo-url>
2️⃣ Configurer la base de données

Créer une base MySQL :

CREATE DATABASE eduquiz;
3️⃣ Configurer le fichier .env

4️⃣ Lancer le projet

Avec XAMPP :

démarrer Apache
démarrer MySQL
placer le projet dans htdocs

Puis accéder :

http://localhost/EduQuiz/public
📅 Planning du Projet
Jour	Travail
Jour 1	Analyse + Diagrammes
Jour 2	Authentification + Quiz
Jour 3	Questions + Passage Quiz
Jour 4	Résultats + Dashboard
Jour 5	Tests + Merge + Finalisation
📌 Diagrammes Réalisés
Diagramme de Cas d’Utilisation

Diagramme de Classes
ERD (Entity Relationship Diagram)
✅ Bonnes Pratiques Utilisées
Programmation Orientée Objet
Encapsulation
Typage strict PHP
Architecture propre
Séparation des responsabilités
Utilisation Git/GitHub
📄 Licence

Projet pédagogique réalisé dans le cadre de la formation CodeAcademy.