<?php
namespace App\Repositories;
use PDO;

class HelpRequestRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllActiveRequests() {

        $sql = "SELECT hr.*, 
       u.nom as student_nom, 
       u.prenom as student_prenom,
        s.name as technology_name
        FROM help_requests hr
        JOIN users u ON hr.student_id = u.id 
        JOIN skills s ON hr.skill_id = s.id
        ORDER BY hr.id DESC;";
                
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create(array $data): bool {
        $sql = "INSERT INTO help_requests (title, description, status, student_id, tutor_id, skill_id) 
                VALUES (:title, :description, :status, :student_id, NULL, :skill_id)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':status'      => $data['status'],
            ':student_id'  => $data['student_id'],
            ':skill_id'    => $data['skill_id']
        ]);
    }
    public function getRequestById(int $id): ?array {
    $sql = "SELECT hr.*, 
                   u.nom as student_nom, u.prenom as student_prenom,
                   t.nom as tutor_nom, t.prenom as tutor_prenom,
                   s.name as technology_name
            FROM help_requests hr
            JOIN users u ON hr.student_id = u.id 
            JOIN skills s ON hr.skill_id = s.id
            LEFT JOIN users t ON hr.tutor_id = t.id
            WHERE hr.id = :id";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result ? $result : null;
}

/**
 * Kat-sifet l-ID dyal l-tuteur, kat-baddel l-statut l 'En cours', w kat-creeyi l-lien
 */
public function acceptRequest(int $requestId, int $tutorId, string $runLink): bool {
    $sql = "UPDATE help_requests 
            SET tutor_id = :tutor_id, 
                status = 'En cours', 
                run_link = :run_link 
            WHERE id = :id AND tutor_id IS NULL"; // 'IS NULL' bach may-ji7ch tuteur akhor y-chffr l-ticket
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':tutor_id' => $tutorId,
        ':run_link' => $runLink,
        ':id'       => $requestId
    ]);
}

}