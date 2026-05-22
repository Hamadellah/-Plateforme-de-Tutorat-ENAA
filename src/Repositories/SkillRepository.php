<?php
namespace App\Repositories;

use PDO;

class SkillRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }


    public function getAllSkills(): array {
        $sql = "SELECT id, name FROM skills ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}