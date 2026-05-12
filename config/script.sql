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

-- QUESTION 1
INSERT INTO questions (question, quiz_id) VALUES ('What does PHP stand for ?', 1);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('Personal Home Page', 1, 1),
('Private Hosting Program', 0, 1),
('Public Hypertext Processor', 0, 1);

-- QUESTION 2
INSERT INTO questions (question, quiz_id) VALUES ('Which language is used for styling web pages ?', 1);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('JavaScript', 0, 2),
('CSS', 1, 2),
('Python', 0, 2);

-- QUESTION 3

-- QUESTION 4
INSERT INTO questions (question, quiz_id) VALUES ('Which of these is a database system ?', 1);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('MySQL', 1, 4),
('Laravel', 0, 4),
('HTML', 0, 4);

-- QUESTION 5
INSERT INTO questions (question, quiz_id) VALUES ('What is the correct way to declare a variable in PHP ?', 1);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('$variable', 1, 5),
('var variable', 0, 5),
('let variable', 0, 5);

-- QUESTION 6
INSERT INTO questions (question, quiz_id) VALUES ('Which one is a frontend technology ?', 1);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('Node.js', 0, 6),
('React', 1, 6),
('PHP', 0, 6);

-- QUESTION 7
INSERT INTO questions (question, quiz_id) VALUES ('What is used to connect PHP with database ?', 1);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('PDO', 1, 7),
('HTML', 0, 7),
('CSS', 0, 7);
INSERT INTO answers (answer, is_correct, question_id) VALUES 
('SELECT', FALSE, 2),
('INSERT', TRUE, 2),
('UPDATE', FALSE, 2);

INSERT INTO results (user_id, quiz_id, score) VALUES 
(2, 1, 100);

INSERT INTO results (user_id, quiz_id, score) VALUES 
(3, 1, 50);