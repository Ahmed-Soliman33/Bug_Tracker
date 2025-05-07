<?php

class Bug
{
    private $id;
    private $bug_name;
    private $project_id;
    private $category;
    private $details;
    private $assigned_to;
    private $status;
    private $priority;
    private $created_at;



    public function __construct(
        $bug_name,
        $project_id,
        $category,
        $details,
        $assigned_to,
        $status,
        $priority,
    ) {
        $this->bug_name = $bug_name;
        $this->project_id = $project_id;
        $this->category = $category;
        $this->details = $details;
        $this->assigned_to = $assigned_to;
        $this->status = $status;
        $this->priority = $priority;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getBugName()
    {
        return $this->bug_name;
    }
    public function getProjectId()
    {
        return $this->project_id;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getDetails()
    {
        return $this->details;
    }
    public function getAssignedTo()
    {
        return $this->assigned_to;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getPriority()
    {
        return $this->priority;
    }
}

?>