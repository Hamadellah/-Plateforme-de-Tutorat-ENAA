-- Création de la table roles
create DATABASE ENAA;
use ENAA;
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL UNIQUE
);

-- Création de la table badges
CREATE TABLE badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

-- Création de la table skills
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Création de la table users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    points INT DEFAULT 0,
    label_role VARCHAR(255),
    CONSTRAINT fk_users_roles FOREIGN KEY (label_role) REFERENCES roles(label) ON UPDATE CASCADE
);

-- Création de la table user_badges (Table de liaison)
CREATE TABLE user_badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    badge_id INT NOT NULL,
    awarded_at DATE NOT NULL,
    CONSTRAINT fk_ub_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ub_badge FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
);

-- Création de la table user_skills (Table de liaison)
CREATE TABLE user_skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_id INT NOT NULL,
    niveau VARCHAR(50) NOT NULL,
    CONSTRAINT fk_us_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_us_skill FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE
);

-- Création de la table help_requests
CREATE TABLE help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL,
    student_id INT NOT NULL,
    tutor_id INT,
    skill_id INT NOT NULL,
    CONSTRAINT fk_hr_student FOREIGN KEY (student_id) REFERENCES users(id),
    CONSTRAINT fk_hr_tutor FOREIGN KEY (tutor_id) REFERENCES users(id),
    CONSTRAINT fk_hr_skill FOREIGN KEY (skill_id) REFERENCES skills(id)
);

-- Création de la table reviews
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment VARCHAR(255) NOT NULL,
    id_helprequest INT NOT NULL UNIQUE,
    CONSTRAINT fk_reviews_request FOREIGN KEY (id_helprequest) REFERENCES help_requests(id) ON DELETE CASCADE
);
-- 1. Insertion des Rôles
INSERT INTO roles (label) VALUES 
('Étudiant'),
('Tuteur'),
('Administrateur');

-- 2. Insertion des Badges
INSERT INTO badges (title) VALUES 
('Premier Pas'),
('Entraide Distinguée'),
('Expert SQL');

-- 3. Insertion des Compétences (Skills)
INSERT INTO skills (name) VALUES 
('Base de données / SQL'),
('Algorithmique en Python'),
('Développement Web');

-- 4. Insertion des Utilisateurs (Users)
INSERT INTO users (nom, prenom, email, password, points, label_role) VALUES 
('Alaoui', 'Yassine', 'yassine@email.com', 'pass123', 50, 'Étudiant'),
('Bennani', 'Sara', 'sara@email.com', 'secure456', 200, 'Tuteur'),
('Rami', 'Omar', 'omar@email.com', 'admin789', 0, 'Administrateur');

-- 5. Attribution de Badges aux Utilisateurs (User_Badges)
INSERT INTO user_badges (user_id, badge_id, awarded_at) VALUES 
(1, 1, '2026-01-15'),
(2, 2, '2026-02-20'),
(2, 3, '2026-03-01');

-- 6. Attribution de Compétences aux Utilisateurs (User_Skills)
INSERT INTO user_skills (user_id, skill_id, niveau) VALUES 
(1, 1, 'Débutant'),
(2, 1, 'Expert'),
(2, 3, 'Intermédiaire');

-- 7. Création de Demandes d'Aide (Help_Requests)
-- Yassine (id: 1) demande de l'aide en SQL (id: 1), et Sara (id: 2) accepte d'être le tuteur.
INSERT INTO help_requests (title, description, status, student_id, tutor_id, skill_id) VALUES 
('Besoin d''aide sur les jointures', 'Je ne comprends pas la différence entre LEFT JOIN et INNER JOIN.', 'Terminé', 1, 2, 1);

-- 8. Ajout d'un Avis sur la Demande d'Aide (Reviews)
INSERT INTO reviews (comment, id_helprequest) VALUES 
('Explications très claires de la part de Sara, merci !', 1);
UPDATE users 
SET password = '12' 
WHERE email = 'yassine@email.com';
SELECT hr.*, 
       u.nom as student_nom, 
       u.prenom as student_prenom,
       s.name as technology_name
FROM help_requests hr
JOIN users u ON hr.student_id = u.id 
JOIN skills s ON hr.skill_id = s.id
ORDER BY hr.id DESC;
INSERT INTO help_requests (title, description, status, student_id, tutor_id, skill_id) 
                VALUES ("othmane", "othmane", "othmane", "1", NULL, "1")