<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');

class CommentRepo {
    private $db;

    function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addComment($task_id, $user_owner, $content) {
        $query = 'INSERT INTO comments (task_id, user_owner, content) VALUES (:task_id, :owner, :body)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':owner', $user_owner);
        $stmt->bindParam(':body', $content);

        if(!$stmt->execute()) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function editComment($comment_id,  $content) {
        $query = 'UPDATE comments SET content = :content WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $comment_id);
        return $stmt->execute();
    }

    public function deleteComment($comment_id) {
        $query = 'DELETE FROM comments WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $comment_id);
        return $stmt->execute();
    }

    public function getTaskComments($task_id) {
        $query = 'SELECT * FROM comments WHERE task_id = :task_id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':task_id', $task_id);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}