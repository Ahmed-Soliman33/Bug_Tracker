<?php

class Project
{
    private $project_id;
    private $project_title;
    private $project_type;
    private $project_description;
    private $created_at;



    public function __construct($project_title, $project_type, $project_description)
    {
        $this->project_title = $project_title;
        $this->project_type = $project_type;
        $this->project_description = $project_description;
    }

    public function getProjectTitle()
    {
        return $this->project_title;
    }
    public function getProjectType()
    {
        return $this->project_type;
    }
    public function getProjectDesc()
    {
        return $this->project_description;
    }
    public function getProjectId()
    {
        return $this->project_id;
    }
    public function getCreated_at()
    {
        return $this->created_at;
    }

}

?>