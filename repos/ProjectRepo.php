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

    public static function getProjectsByUserId($userID) {
        $query = "SELECT * FROM projects_users WHERE user_id = :userID";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllProjects($userID) {
        $query = "SELECT is_admin FROM users WHERE id = :userID";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['is_admin']) {
            $query2 = "
            SELECT
                p.id AS project_id,
                p.name AS project_name,
                u.username AS owner_username,
                (SELECT COUNT(pu.user_id) FROM projects_users pu WHERE pu.project_id = p.id) AS num_members,
                (SELECT COUNT(c.id) FROM columns c WHERE c.project_id = p.id) AS num_columns,
                (SELECT COUNT(t.id) FROM tasks t WHERE t.project_id = p.id) AS num_tasks
            FROM projects p
            JOIN users u ON p.owner = u.id
        ";
            $stmt2 = BaseRepo::getDB()->prepare($query2);
            $stmt2->execute();
            return $stmt2->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }

    public static function getProjectsInformationByUserId($userID) {
        $query = "
        SELECT
            p.id as PROJECT_ID,
            p.owner AS OWNER,
            u.username AS NAME,
            (SELECT COUNT(c.id) FROM columns c WHERE c.project_id = p.id) AS NUMCOLS,
            (SELECT COUNT(t.id) FROM tasks t WHERE t.project_id = p.id) AS NUMTASKS,
            (SELECT COUNT(pu2.user_id) FROM projects_users pu2 WHERE pu2.project_id = p.id) AS NUMUSERS
        FROM projects_users pu
        JOIN projects p ON p.id = pu.project_id
        JOIN users u on u.id = pu.user_id
        WHERE pu.user_id = :userID
        ";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteProject($id) {
        $query = "DELETE FROM projects_users WHERE project_id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        if (!$stmt->execute()) {
            return null;
        }

        $query2 = "DELETE FROM projects WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query2);
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

    public static function changeProjectName($id, $name) {
        $query = "UPDATE projects SET name = :name WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public static function changeName($name, $id) {
        $query = "UPDATE projects SET name = :name WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function getOwner($projectID) {
        $query = "SELECT owner FROM projects WHERE id = :projectID";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->execute();
    }
}

