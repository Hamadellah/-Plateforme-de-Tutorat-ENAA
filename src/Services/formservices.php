<?php
namespace App\Services;

use App\Repositories\HelpRequestRepository;
use PDO;

class TicketService {
    private $helpRepo;


    public function __construct(HelpRequestRepository $helpRepo) {
        $this->helpRepo = $helpRepo;
    }

    public function checkAuth(): void {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
    }


    public function handleSubmission(array $postData): ?string {
        if (!isset($postData['submit_question'])) {
            return null; 
        }

        $title = trim($postData['title'] ?? '');
        $description = trim($postData['description'] ?? '');
        $skill_id = filter_var($postData['skill_id'] ?? null, FILTER_VALIDATE_INT);
        $student_id = $_SESSION['user_id'] ?? null;


        if (empty($title) || empty($description) || !$skill_id) {
            return "Veuillez remplir tous les champs correctement.";
        }

        if (!$student_id) {
            return "Erreur : Vous devez être connecté pour poser une question.";
        }

        $requestData = [
            'title'        => $title,
            'description'  => $description,
            'status'       => 'En attente',
            'student_id'   => $student_id,
            'skill_id'     => $skill_id
        ];

        // Insertion en BDD
        if ($this->helpRepo->create($requestData)) {
            header("Location: dashboard.php?success=1");
            exit();
        }

        return "Une erreur est survenue lors de l'enregistrement.";
    }
}