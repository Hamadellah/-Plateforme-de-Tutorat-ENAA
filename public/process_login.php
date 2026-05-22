<?php
// 1. Islah l-paths (Kollchi b src sghira o slashs correct)
require_once __DIR__ . '/../src/Services/connection.php';
require_once __DIR__ . '/../src/Repositories/UserRepository.php';
require_once __DIR__ . '/../src/Services/UserService.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = \Services\Connection::getConnection();
    $repo = new \App\Repositories\UserRepository($db);
    $service = new \Services\UserService($repo);

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = $service->login($email, $password);
    if ($user) {
        $_SESSION['user']= $user;
        $_SESSION['user_id'] = $user['id'];

        if (isset($user['label_role']) && $user['label_role'] === 'Étudiant') {

            header("Location: ../views/dashboard.php");

        } else {

            echo "Redirecting to user dashboard...";
        }
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
        exit();
    }
}