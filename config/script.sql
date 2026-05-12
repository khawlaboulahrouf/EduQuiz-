CREATE DATABASE eduQuiz ;

use eduQuiz;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    role ENUM('formateur', 'etudiant')
);

CREATE TABLE quizzes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    description TEXT,
    code VARCHAR(20) UNIQUE,
    user_id INT,

    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question TEXT,
    quiz_id INT,

    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);

CREATE TABLE answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    answer TEXT,
    is_correct BOOLEAN,
    question_id INT,

    FOREIGN KEY (question_id) REFERENCES questions(id)
);

CREATE TABLE results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    quiz_id INT,
    score INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);
-- 1. Insertion des Utilisateurs (Le créateur et les participants)
INSERT INTO users (name, email, password, role) VALUES 
('Jean Formateur', 'jean@eduquiz.com', 'password_hash_1', 'formateur'),
('Alice Etudiante', 'alice@student.com', 'password_hash_2', 'etudiant'),
('Bob Etudiant', 'bob@student.com', 'password_hash_3', 'etudiant');

-- 2. Insertion d'un Quiz
-- On lie ce quiz à l'utilisateur ID 1 (Jean Formateur)
INSERT INTO quizzes (title, description, code, user_id) VALUES 
('Bases de SQL', 'Évaluation sur les commandes DDL et DML.', 'SQL-2026', 1);

-- 3. Insertion de Questions pour ce Quiz (quiz_id = 1)
INSERT INTO questions (question, quiz_id) VALUES 
('Que signifie l''acronyme SQL ?', 1),
('Quelle commande permet d''ajouter des données ?', 1);

-- 4. Insertion de Réponses pour chaque Question
-- Réponses pour la Question 1 (id 1)
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('Structured Query Language', TRUE, 1),
('Simple Query Language', FALSE, 1),
('Standard Question List', FALSE, 1);

-- Réponses pour la Question 2 (id 2)
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('SELECT', FALSE, 2),
('INSERT', TRUE, 2),
('UPDATE', FALSE, 2);

-- 5. Insertion de Résultats (Simulation de passage d'examen)
-- Alice (user_id 2) a fait le quiz (quiz_id 1) et a eu 100
INSERT INTO results (user_id, quiz_id, score) VALUES 
(2, 1, 100);

-- Bob (user_id 3) a fait le quiz (quiz_id 1) et a eu 50
INSERT INTO results (user_id, quiz_id, score) VALUES 
(3, 1, 50);