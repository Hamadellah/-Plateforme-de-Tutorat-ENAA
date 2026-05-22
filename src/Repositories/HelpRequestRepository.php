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

}