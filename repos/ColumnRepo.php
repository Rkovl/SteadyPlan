<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');

class ColumnRepo {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addColumn($projectID, $name, $position, $description = null) {
        $query = "INSERT INTO columns (project_id, name, position, description) VALUES (:projectID, :name, :position, :description) RETURNING id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':description', $description);

        if(!$stmt->execute()) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function getProjectColumns($projectID) {
        // Fetch column UUIDs
        $stmt = $this->db->prepare("SELECT id, name FROM columns WHERE project_id = :projectID ORDER BY position");
        $stmt->bindParam(':projectID', $projectID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteColumn($columnID) {
        $query = "DELETE FROM columns WHERE id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }

    public function changeName($name, $projectID, $columnID) {
        $query = "UPDATE columns SET name = :name WHERE project_id = :projectID AND id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }

    public function changePosition($position, $projectID, $columnID) {
        $query = "UPDATE columns SET position = :position WHERE project_id = :projectID AND id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }

    public function changeDescription($description, $projectID, $columnID) {
        $query = "UPDATE columns SET description = :description WHERE project_id = :projectID AND id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }
}

