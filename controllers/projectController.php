<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectRepo.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectUserRepo.php');

class ProjectController {
    private $projectRepo;
    private $projectUserRepo;

    function __construct() {
        $this->projectRepo = new projectRepo();
        $this->projectUserRepo = new projectUserRepo();
    }
    
    function createProject() {
        try {
            if($_SERVER["REQUEST_METHOD"] !== "POST") {
                http_response_code(405);
                echo json_encode(['error' => 'Method not POST']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset($data["project_owner"]) && !isset($data["project_name"])) {
                http_response_code(400);
                echo json_encode(['error' => 'Project owner and name are required']);
            }

            $owner = $data["project_owner"];
            $name = $data["project_name"];

            $this->projectRepo->addProject($owner, $name);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }
}