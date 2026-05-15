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
INSERT INTO users (name, email, password, role) VALUES 
('Jean Formateur', 'jean@eduquiz.com', 'password_hash_1', 'formateur'),
('Alice Etudiante', 'alice@student.com', 'password_hash_2', 'etudiant'),
('Bob Etudiant', 'bob@student.com', 'password_hash_3', 'etudiant');

INSERT INTO quizzes (title, description, code, user_id) VALUES 
('Bases de SQL', 'Évaluation sur les commandes DDL et DML.', 'SQL-2026', 1);

INSERT INTO questions (question, quiz_id) VALUES 
('Que signifie l''acronyme SQL ?', 1),
('Quelle commande permet d''ajouter des données ?', 1);

INSERT INTO answers (answer, is_correct, question_id) VALUES 
('Structured Query Language', TRUE, 1),
('Simple Query Language', FALSE, 1),
('Standard Question List', FALSE, 1);

INSERT INTO answers (answer, is_correct, question_id) VALUES 
('SELECT', FALSE, 2),
('INSERT', TRUE, 2),
('UPDATE', FALSE, 2);

INSERT INTO results (user_id, quiz_id, score) VALUES 
(2, 1, 100);

INSERT INTO results (user_id, quiz_id, score) VALUES 
(3, 1, 50);



-- ============================================================
--  TABLE SUPPLÉMENTAIRE : student_answers
--  Nécessaire pour l'Axe 4 (afficher la correction)
--  À ajouter au script.sql du groupe
--
--  Cette table enregistre quelle réponse chaque étudiant
--  a choisie pour chaque question d'un quiz.
-- ============================================================

USE eduQuiz;

CREATE TABLE IF NOT EXISTS student_answers (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    user_id     INT NOT NULL,
    quiz_id     INT NOT NULL,
    question_id INT NOT NULL,
    answer_id   INT NOT NULL,
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)     REFERENCES users(id),
    FOREIGN KEY (quiz_id)     REFERENCES quizzes(id),
    FOREIGN KEY (question_id) REFERENCES questions(id),
    FOREIGN KEY (answer_id)   REFERENCES answers(id),

    UNIQUE KEY unique_answer (user_id, quiz_id, question_id)
);

-- ============================================================
--  Exemple de données de test (cohérent avec script.sql)
--  Alice (id=2) a répondu au quiz SQL-2026 (id=1)
--    Question 1 → réponse 1 (correcte : "Structured Query Language")
--    Question 2 → réponse 5 (correcte : "INSERT")
-- ============================================================

INSERT INTO student_answers (user_id, quiz_id, question_id, answer_id) VALUES
(2, 1, 1, 1),    
(2, 1, 2, 5),  
(3, 1, 1, 2),    
(3, 1, 2, 5);   
