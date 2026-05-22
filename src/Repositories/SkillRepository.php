<?php
namespace App\Repositories;

use PDO;

class SkillRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère toutes les compétences triées par nom
     * @return array
     */
    public function getAllSkills(): array {
        $sql = "SELECT id, name FROM skills ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}