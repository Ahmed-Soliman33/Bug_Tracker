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
            $conn = $this->db->connection;

            // Sanitize inputs
            $bugName = mysqli_real_escape_string($conn, $bug->getBugName());
            $projectId = (int) $bug->getProjectId();
            $category = mysqli_real_escape_string($conn, $bug->getCategory());
            $details = mysqli_real_escape_string($conn, $bug->getDetails());
            $assignedTo = (int) $bug->getAssignedTo() || null;
            $status = mysqli_real_escape_string($conn, $bug->getStatus());
            $priority = mysqli_real_escape_string($conn, $bug->getPriority());

            $checkStaffQuery = "SELECT * FROM staff WHERE staff_id = $assignedTo";
            $resultCheck = $this->db->select($checkStaffQuery);

            if ($resultCheck) {
                $query = "INSERT INTO bugs (bug_name, project_id, category, details, assigned_to, status, priority)
                  VALUES ('$bugName', $projectId, '$category', '$details', $assignedTo, '$status', '$priority')";
            } else {
                $query = "INSERT INTO bugs (bug_name, project_id, category, details, status, priority)
                  VALUES ('$bugName', $projectId, '$category', '$details', '$status', '$priority')";
            }



            $result = $this->db->insert($query);

            if ($result) {
                $bugId = $conn->insert_id;

                $query_bug_staff = "INSERT INTO bug_staff (bug_id, staff_id) VALUES ($bugId, $assignedTo)";
                $result_bug_staff = $this->db->insert($query_bug_staff);

                if ($result_bug_staff) {
                    $this->db->closeConnection();
                    return true;
                } else {
                    echo "❌ Error inserting into bug_staff table.";
                    $this->db->closeConnection();
                    return false;
                }
            } else {
                echo "❌ Error inserting bug.";
                $this->db->closeConnection();
                return false;
            }
        } else {
            echo "❌ Error: Could not connect to the database.";
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
            $query = "SELECT * FROM bugs WHERE id = $bugId";

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
            $bug_assigned_to = $bug->getAssignedTo();


            $update_bugs = "UPDATE bugs
                            SET 
                                bug_name = '$bug_name',
                                details = '$bug_details',
                                status = '$bug_status',
                                assigned_to = $bug_assigned_to,
                                priority = '$bug_priority'
                                
                            WHERE 
                                id = $bugId;";



            $result_bug_staff = null;

            $is_bug_in_staff_bug = "select * from bug_staff where bug_id = $bugId;";
            $result_is_bug_in_staff_bug = $this->db->select($is_bug_in_staff_bug);
            if (count($result_is_bug_in_staff_bug) > 0) {
                $update_bug_staff = "UPDATE bug_staff
                            SET 
                                staff_id = $bug_assigned_to
                                WHERE 
                                bug_id = $bugId;";
                $result_bug_staff = $this->db->update($update_bug_staff);
            } else {
                $insert_bug_staff_query = "INSERT INTO bug_staff (bug_id, staff_id) VALUES ($bugId , $bug_assigned_to);";
                $result_bug_staff = $this->db->insert($insert_bug_staff_query);
            }



            $result_bugs = $this->db->update($update_bugs);
            if ($result_bugs && $result_bug_staff) {
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