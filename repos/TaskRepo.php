<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');

class TaskRepo {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getTask($taskID) {
        $query = "SELECT * FROM tasks WHERE id = :taskID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':taskID', $taskID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTasksFromColumn($columnID) {
        $query = "SELECT * FROM tasks WHERE column_id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':columnID', $columnID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasksFromProject($projectID) {
        $query = "SELECT * FROM tasks WHERE project_id = :projectID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($projectID, $columnID, $name, $description = null) {
        $query = "INSERT INTO tasks (project_id, column_id, name, description) VALUES (:projectID, :columnID, :name, :description) RETURNING id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':columnID', $columnID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function deleteTask($taskID) {
        $query = "DELETE FROM tasks WHERE id = :taskID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':taskID', $taskID);
        return $stmt->execute();
    }

    public function changeColumn($columnID, $taskID) {
        $query = "UPDATE tasks SET column_id = :columnID WHERE id = :taskID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':columnID', $columnID);
        $stmt->bindParam(':taskID', $taskID);
        return $stmt->execute();
    }

    public function changeName($name, $taskID, $projectID, $columnID) {
        $query = "UPDATE tasks SET name = :name WHERE id = :taskID AND project_id = :projectID AND column_id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':taskID', $taskID);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }

    public function changeDescription($description, $taskID, $projectID, $columnID) {
        $query = "UPDATE tasks SET description = :description WHERE id = :taskID AND project_id = :projectID AND column_id = :columnID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':taskID', $taskID);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }
}