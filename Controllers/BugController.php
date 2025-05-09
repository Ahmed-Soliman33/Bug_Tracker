<?php


require_once 'DBController.php';
require_once '../../Models/Bug.php';
class BugController
{
    protected $db;


    public function addBug(Bug $bug)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $bugName = $bug->getBugName();
            $category = $bug->getCategory();
            $details = $bug->getDetails();
            $assignedTo = $bug->getAssignedTo();
            $priority = $bug->getPriority();
            $projectId = $bug->getProjectId();
            $status = $bug->getStatus();

            $query = "INSERT INTO bugs (bug_name, project_id , category , details , assigned_to , status , priority) VALUES ('$bugName', $projectId ,'$category','$details', $assignedTo , '$status' , '$priority')";

            $result = $this->db->insert($query);
            if ($result) {
                $query_bug_staff = "INSERT INTO bug_staff (bug_id, staff_id ) VALUES ($result , $assignedTo)";
                $result_bug_staff = $this->db->insert($query_bug_staff);
                if ($result_bug_staff) {
                    $this->db->closeConnection();
                    return true;
                }
            } else {
                $this->db->closeConnection();
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }


    }

    public function getAllBugs()
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT b.*, p.project_title, s.staff_name AS staffName FROM bugs b LEFT JOIN projects p ON b.project_id = p.project_id LEFT JOIN staff s ON b.assigned_to = s.staff_id;";

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
    public function getBugById($bugId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT * FROM bugs WHERE bug_id = $bugId";

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

    public function assignStaffToBug($bugId, $staffId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "INSERT INTO bug_staff (bug_id, staff_id) VALUES ($bugId , $staffId)";
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
    


    public function removeStaffFromBug($bugId, $staffId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "DELETE FROM bug_staff WHERE bug_id = $bugId AND staff_id = $staffId";
            $result = $this->db->delete($query);
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
    public function getAllBugsWithStaff()
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT 
                        b.id,
                        b.bug_name,
                        b.category,
                        b.details,
                        b.status,
                        b.priority,
                        p.project_name,
                        s.staff_name AS staff_name
                      FROM 
                        bugs b
                      LEFT JOIN 
                        projects p ON b.project_id = p.project_id
                      LEFT JOIN 
                        bug_user bu ON b.id = bu.bug_id
                      LEFT JOIN 
                        staff s ON bu.staff_id = s.staff_id";
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
    public function getBugsForStaff($staffId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT b.id, b.bug_name, b.category, b.details, b.status, b.priority, b.created_at, p.project_title FROM  bugs b
                        JOIN 
                            bug_staff bu ON b.id = bu.bug_id
                        JOIN 
                            staff s ON bu.staff_id = s.staff_id
                        LEFT JOIN 
                            projects p ON b.project_id = p.project_id
                        WHERE 
                            s.staff_id = $staffId;";
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


    public function getAllBugsForCustomer()
{
    $this->db = new DBController;
    if ($this->db->openConnection()) {
        $query = "SELECT 
                    b.id,
                    b.bug_name,
                    b.category,
                    b.details,
                    b.status,
                    b.priority,
                    p.project_name,
                    u.user_name AS customer_name
                  FROM 
                    bugs b
                  LEFT JOIN 
                    projects p ON b.project_id = p.project_id
                  LEFT JOIN 
                    bug_user bu ON b.id = bu.bug_id
                  LEFT JOIN 
                    users u ON bu.user_id = u.user_id";  // ربط البلاغات بالعملاء عبر user_id
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

public function getBugsForCustomer($customerId)
{
    $this->db = new DBController;
    if ($this->db->openConnection()) {
        $query = "SELECT b.id, b.bug_name, b.category, b.details, b.status, b.priority, b.created_at, p.project_title 
                  FROM bugs b
                  JOIN 
                    bug_user bu ON b.id = bu.bug_id
                  JOIN 
                    users u ON bu.user_id = u.user_id  -- ربط البلاغ بالعميل عبر user_id
                  LEFT JOIN 
                    projects p ON b.project_id = p.project_id
                  WHERE 
                    u.user_id = $customerId;";  // شرط البحث بناءً على customerId
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

    

    public function deleteBug($bugId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "DELETE FROM bugs WHERE id = $bugId";
            $result = $this->db->delete($query);
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
    public function updateBug($bugId, Bug $bug)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {

            $bug_name = $bug->getBugName();
            $bug_details = $bug->getDetails();
            $bug_status = $bug->getStatus();
            $bug_priority = $bug->getPriority();


            $query = "UPDATE bugs
                            SET 
                                bug_name = '$bug_name',
                                bug_details = '$bug_details',
                                status = '$bug_status',
                                priority = '$bug_priority',
                            WHERE 
                                bug_id = $bugId;";

            $result = $this->db->update($query);
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



}

?>