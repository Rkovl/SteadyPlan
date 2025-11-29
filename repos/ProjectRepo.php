<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');

class ProjectRepo {
    private $db;

    function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addProject($owner, $name) {
        $query = "INSERT INTO projects (owner, name) VALUES (:owner, :name) RETURNING id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':name', $name);

        if (!$stmt->execute()) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function deleteProject($owner, $id) {
        $query = "DELETE FROM projects WHERE owner = :owner AND id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function changeOwner($owner, $id) {
        $query = "UPDATE projects SET owner = :owner WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function changeName($name, $id) {
        $query = "UPDATE projects SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getOwner($projectID) {
        $query = "SELECT owner FROM projects WHERE id = :projectID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->execute();
    }
}

