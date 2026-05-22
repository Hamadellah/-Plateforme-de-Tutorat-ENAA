<?php 

class HelpRequest {
    private $id;
    private $student_id;
    private $skill_id;
    private $description;
    private $created_at;
    private $updated_at;

    public function __construct($id, $student_id, $skill_id, $description, $created_at, $updated_at) {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->skill_id = $skill_id;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters and Setters
}
