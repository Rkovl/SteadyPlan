<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/BaseRepo.php');

class ProjectRepo extends BaseRepo {
    public static function addProject($owner, $name) {
        $query = "INSERT INTO projects (owner, name) VALUES (:owner, :name) RETURNING id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':name', $name);

        if (!$stmt->execute()) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public static function deleteProject($owner, $id) {
        $query = "DELETE FROM projects WHERE owner = :owner AND id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function changeOwner($owner, $id) {
        $query = "UPDATE projects SET owner = :owner WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function changeName($name, $id) {
        $query = "UPDATE projects SET name = :name WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

