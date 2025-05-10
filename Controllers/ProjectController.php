<?php

require_once '../../Models/Project.php';
require_once '../../Controllers/DBController.php';

class ProjectController
{
    protected $db;


    public function addProject(Project $project)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $title = $project->getProjectTitle();
            $type = $project->getProjectType();
            $desc = $project->getProjectDesc();
            $query = "INSERT INTO projects (project_title, project_type, project_description) VALUES ('$title','$type','$desc')";

            $result = $this->db->insert($query);
            if ($result) {
                $this->db->closeConnection();
                return true;
            } else {
                $this->db->closeConnection();
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }


    }
    public function getAllProjects()
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * from projects";

            $result = $this->db->select($query);
            if ($result) {
                $this->db->closeConnection();
                return $result;
            } else {
                $this->db->closeConnection();
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }


    }

    public function deleteProject($projectId)
    {
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            // Start a transaction to ensure data consistency
            $this->db->connection->begin_transaction();

            try {
                // Step 1: Delete related records from bug_customer
                $query_bug_customer = "DELETE FROM bug_customer WHERE bug_id IN (SELECT id FROM bugs WHERE project_id = ?)";
                $stmt_bug_customer = $this->db->connection->prepare($query_bug_customer);
                $stmt_bug_customer->bind_param("i", $projectId);
                $stmt_bug_customer->execute();
                $stmt_bug_customer->close();

                // Step 2: Delete related records from bug_staff
                $query_bug_staff = "DELETE FROM bug_staff WHERE bug_id IN (SELECT id FROM bugs WHERE project_id = ?)";
                $stmt_bug_staff = $this->db->connection->prepare($query_bug_staff);
                $stmt_bug_staff->bind_param("i", $projectId);
                $stmt_bug_staff->execute();
                $stmt_bug_staff->close();

                // Step 3: Delete bugs related to the project
                $query_bugs = "DELETE FROM bugs WHERE project_id = ?";
                $stmt_bugs = $this->db->connection->prepare($query_bugs);
                $stmt_bugs->bind_param("i", $projectId);
                $stmt_bugs->execute();
                $stmt_bugs->close();

                // Step 4: Delete the project
                $query_project = "DELETE FROM projects WHERE project_id = ?";
                $stmt_project = $this->db->connection->prepare($query_project);
                $stmt_project->bind_param("i", $projectId);
                $stmt_project->execute();
                $stmt_project->close();

                // Commit the transaction
                $this->db->connection->commit();
                $this->db->closeConnection();

                // Debug: Log successful deletion
                error_log("Project deleted successfully: project_id=$projectId");

                return true;
            } catch (Exception $e) {
                // Rollback the transaction on error
                $this->db->connection->rollback();
                $this->db->closeConnection();

                // Debug: Log the error
                error_log("Error deleting project: project_id=$projectId, error=" . $e->getMessage());

                $_SESSION["errMsg"] = "Failed to delete project: " . $e->getMessage();
                return false;
            }
        } else {
            $_SESSION["errMsg"] = "Database connection error.";
            return false;
        }
    }





}

?>