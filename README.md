# PeerSync 🚀

**PeerSync** est une plateforme d'entraide et de tutorat entre étudiants au sein d'un bootcamp. L'objectif principal est de permettre à tout étudiant bloqué sur un problème de code (PHP, JavaScript, SQL...) de créer un ticket de demande d'aide ("Help Request"). Un autre étudiant disponible (Tuteur) peut alors accepter la demande et le rejoindre instantanément via un lien de réunion virtuel généré dynamiquement grâce à l'API Jitsi Meet.

## 🛠️ Stack Technique & Architecture

- **Backend :** PHP 8.x — Architecture MVC et Programmation Orientée Objet (POO).
- **Base de données :** MySQL avec l'interface PDO.
- **Frontend :** Tailwind CSS pour une interface utilisateur moderne, fluide et responsive (Gestion du Dark Mode incluse).
- **Visioconférence :** Intégration de l'API Jitsi Meet pour la génération dynamique et sécurisée des salons de réunion.
- **Design Pattern :** Repository Pattern (séparation stricte de la logique de persistance des données et des vues PHP).

## 📂 Structure du Projet

```text
Plateforme de Tutorat ENAA/
│
├── config/                  # Configuration de la base de données et des sessions
├── public/                  # Actifs globaux (CSS compilé, Images, JavaScript global)
├── src/                     # Logique métier et classes du Core (POO)
│   ├── Models/              # Classes entités (HelpRequest, User...)
│   └── Repositories/        # Classes d'accès aux données (ex: HelpRequestRepository.php)
├── views/                   # Fichiers de présentation (Templates HTML/PHP)
│   ├── dashboard.php        # Tableau de bord listant tous les tickets ouverts
│   ├── ticket_form.php      # Formulaire de création d'une nouvelle demande d'aide
│   └── ticket_details.php   # Page de détails du ticket (Bouton d'acceptation du tuteur)
├── login.php                # Page d'authentification et de simulation des rôles
└── README.md                # Le présent fichier
````
🚀 Installation en Local (Environnement XAMPP)
1. Clonage et déplacement du projet
Placez l'intégralité du dossier Plateforme de Tutorat ENAA dans le répertoire racine de votre serveur local (généralement C:\xampp\htdocs\ sous Windows).

2. Importation de la Base de Données
Ouvrez votre gestionnaire phpMyAdmin (http://localhost/phpmyadmin/).

Créez une nouvelle base de données nommée ENAA.

Importez votre fichier SQL ou exécutez la requête de structure suivante pour configurer la table principale :

SQL
CREATE TABLE help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('pending', 'resolved') DEFAULT 'pending',
    student_id INT NOT NULL,
    tutor_id INT NULL,
    meet_link VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
3. Configuration des accès de connexion
Assurez-vous que les identifiants de connexion PDO configurés dans vos fichiers de dépôts (Repositories) correspondent à ceux de votre instance MySQL locale (Par défaut sur XAMPP : utilisateur root et aucun mot de passe).

💻 Tester le Flux de Travail (Workflow nominal)
Pour tester de manière rigoureuse les mécanismes d'authentification par session, la sécurité anti-auto-assistance (interdiction d'accepter son propre ticket) ainsi que la mise à jour automatique du statut à resolved :

Ouvrez deux navigateurs différents ou utilisez une fenêtre de navigation privée distincte pour éviter tout conflit de session.

Utilisateur A (Étudiant) : Accédez à login.php, simulez la connexion d'un compte étudiant, puis créez un ticket d'assistance via le fichier ticket_form.php.

Utilisateur B (Tuteur) : Sur l'autre fenêtre/navigateur, accédez à login.php, connectez-vous avec le profil d'un tuteur.

Prise en charge du ticket : Depuis le tableau de bord (dashboard.php) du Tuteur, cliquez sur le ticket fraîchement créé pour voir ses détails, puis cliquez sur "Aider sa7bi". Le système mettra automatiquement à jour le statut du ticket en base de données et affichera un bloc de succès vert contenant le bouton d'accès au salon de réunion Jitsi.

🛑 Historique des Correctifs Majeurs (Bug Log)
Gestion des conflits de session : Intégration de unset() et du nettoyage de session lors du changement d'utilisateur sur la page de simulation pour détruire les anciens jetons d'identification en cache.

Sécurisation des types et redirections : Résolution d'un crash critique (Fatal error: Uncaught TypeError) en appliquant un transtypage strict (int) sur l'identifiant utilisateur stocké en session et en ajoutant impérativement l'instruction exit() après chaque en-tête de redirection (header("Location: ...")).

Persistance du statut : Modification de la requête préparée SQL dans acceptRequest() pour veiller à ce que l'état passe correctement de pending à resolved lors de la prise en charge d'un ticket.
