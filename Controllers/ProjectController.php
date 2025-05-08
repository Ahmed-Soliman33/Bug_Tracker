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
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query_bugs = "DELETE FROM bugs WHERE project_id = $projectId";
            $query = "DELETE FROM projects WHERE project_id = $projectId";
            $result_bugs = $this->db->delete($query_bugs);
            $result = $this->db->delete($query);
            if ($result && $result_bugs) {
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






}

?>