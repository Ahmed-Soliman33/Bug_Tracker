<?php


require_once 'DBController.php';
require_once 'AuthController.php';
require_once 'CustomerController.php';
require_once '../../Models/Bug.php';
class BugController
{
    protected $db;


    public function addBug(Bug $bug)
    {
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            $conn = $this->db->connection;

            // Start a transaction for data consistency
            $conn->begin_transaction();

            try {
                // Sanitize and prepare inputs
                $bugName = $bug->getBugName();
                $projectId = (int) $bug->getProjectId();
                $category = $bug->getCategory();
                $details = $bug->getDetails();
                $assignedTo = $bug->getAssignedTo();
                $status = $bug->getStatus();
                $priority = $bug->getPriority();

                // Debug: Log input values
                error_log("addBug: bug_name=$bugName, project_id=$projectId, assigned_to=$assignedTo, user_role=" . $_SESSION['userRole']);

                if ($_SESSION['userRole'] != 'customer') {
                    // Check if assignedTo is valid (not null and exists in staff)
                    if ($assignedTo !== null && $assignedTo > 0) {
                        $checkStaffQuery = "SELECT staff_id FROM staff WHERE staff_id = ?";
                        $stmt = $conn->prepare($checkStaffQuery);
                        $stmt->bind_param("i", $assignedTo);
                        $stmt->execute();
                        $resultCheck = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                        $stmt->close();

                        // Debug: Log staff check result
                        error_log("addBug: staff_check_result=" . json_encode($resultCheck));

                        if (empty($resultCheck)) {
                            throw new Exception("Invalid staff_id: $assignedTo does not exist in staff table.");
                        }

                        // Insert bug with assigned_to
                        $query = "INSERT INTO bugs (bug_name, project_id, category, details, assigned_to, status, priority) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("sisssis", $bugName, $projectId, $category, $details, $assignedTo, $status, $priority);
                    } else {
                        // Insert bug without assigned_to
                        $query = "INSERT INTO bugs (bug_name, project_id, category, details, status, priority) 
                                  VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("sissss", $bugName, $projectId, $category, $details, $status, $priority);
                    }
                } else {
                    // Customer: Insert bug without assigned_to, status, or priority
                    $query = "INSERT INTO bugs (bug_name, project_id, category, details) 
                              VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("siss", $bugName, $projectId, $category, $details);
                }

                // Execute bug insertion
                $stmt->execute();
                $bugId = $conn->insert_id;
                $stmt->close();

                // Debug: Log inserted bug_id
                error_log("addBug: bug_id=$bugId inserted successfully");

                // Insert into bug_staff or bug_customer
                if ($_SESSION['userRole'] != 'customer') {
                    if ($assignedTo !== null && $assignedTo > 0) {
                        $query_bug_staff = "INSERT INTO bug_staff (bug_id, staff_id) VALUES (?, ?)";
                        $stmt = $conn->prepare($query_bug_staff);
                        $stmt->bind_param("ii", $bugId, $assignedTo);
                        $stmt->execute();
                        $stmt->close();

                        // Debug: Log bug_staff insertion
                        error_log("addBug: bug_staff inserted for bug_id=$bugId, staff_id=$assignedTo");
                    }
                } else {
                    // Get customer_id
                    $authController = new AuthController();
                    $user = $authController->getUserById($_SESSION['userId']);
                    if (!$user) {
                        throw new Exception("User not found.");
                    }
                    $customerController = new CustomerController();
                    $customer = $customerController->getCustomerByEmail($user[0]["email"]);
                    if (!$customer) {
                        throw new Exception("Customer not found.");
                    }
                    $customerId = (int) $customer[0]["customer_id"];

                    // Debug: Log customer_id
                    error_log("addBug: customer_id=$customerId");

                    $query_bug_customer = "INSERT INTO bug_customer (bug_id, customer_id) VALUES (?, ?)";
                    $stmt = $conn->prepare($query_bug_customer);
                    $stmt->bind_param("ii", $bugId, $customerId);
                    $stmt->execute();
                    $stmt->close();

                    // Debug: Log bug_customer insertion
                    error_log("addBug: bug_customer inserted for bug_id=$bugId, customer_id=$customerId");
                }

                // Commit transaction
                $conn->commit();
                $this->db->closeConnection();

                return true;
            } catch (Exception $e) {
                // Rollback transaction on error
                $conn->rollback();
                $this->db->closeConnection();

                // Debug: Log error
                error_log("addBug: Error - " . $e->getMessage());

                $_SESSION["errMsg"] = "Failed to add bug: " . $e->getMessage();
                return false;
            }
        } else {
            $_SESSION["errMsg"] = "Database connection error.";
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
                        bug_staff bu ON b.id = bu.bug_id
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


    public function getAllBugsForCustomer($customerId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT b.id, b.bug_name, b.category, b.details, b.status, b.priority, b.created_at, p.project_title FROM  bugs b
                        JOIN 
                            bug_customer bc ON b.id = bc.bug_id
                        JOIN 
                            customer c ON bc.customer_id = c.customer_id
                        LEFT JOIN 
                            projects p ON b.project_id = p.project_id
                        WHERE 
                            c.customer_id = $customerId;";
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
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            $conn = $this->db->connection;

            // Start a transaction for data consistency
            $conn->begin_transaction();

            try {
                // Sanitize and prepare inputs
                $bugName = $bug->getBugName();
                $details = $bug->getDetails();
                $status = $bug->getStatus();
                $priority = $bug->getPriority();
                $assignedTo = $bug->getAssignedTo();

                // Debug: Log input values
                error_log("updateBug: bug_id=$bugId, bug_name=$bugName, assigned_to=$assignedTo, status=$status, priority=$priority, user_role=" . ($_SESSION['userRole'] ?? 'unknown'));

                // Validate status and priority
                $validStatuses = ['waiting', 'in_progress', 'solved'];
                $validPriorities = ['low', 'medium', 'high'];
                if ($_SESSION['userRole'] != 'customer' && ($status === null || $priority === null || !in_array($status, $validStatuses) || !in_array($priority, $validPriorities))) {
                    throw new Exception("Invalid or missing status or priority value: status=$status, priority=$priority");
                }

                // Update bugs table
                if ($_SESSION['userRole'] != 'customer') {
                    // Admin or staff: Update all fields
                    if ($assignedTo !== null && $assignedTo > 0) {
                        // Check if assignedTo exists in staff
                        $checkStaffQuery = "SELECT staff_id FROM staff WHERE staff_id = ?";
                        $stmt = $conn->prepare($checkStaffQuery);
                        $stmt->bind_param("i", $assignedTo);
                        $stmt->execute();
                        $resultCheck = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                        $stmt->close();

                        // Debug: Log staff check result
                        error_log("updateBug: staff_check_result=" . json_encode($resultCheck));

                        if (empty($resultCheck)) {
                            throw new Exception("Invalid staff_id: $assignedTo does not exist in staff table.");
                        }

                        $query = "UPDATE bugs SET bug_name = ?, details = ?, status = ?, priority = ?, assigned_to = ? WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ssssii", $bugName, $details, $status, $priority, $assignedTo, $bugId);
                    } else {
                        // Update without assigned_to
                        $query = "UPDATE bugs SET bug_name = ?, details = ?, status = ?, priority = ?, assigned_to = NULL WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ssssi", $bugName, $details, $status, $priority, $bugId);
                    }
                } else {
                    // Customer: Only update bug_name and details
                    $query = "UPDATE bugs SET bug_name = ?, details = ? WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssi", $bugName, $details, $bugId);
                }

                // Execute bug update
                $stmt->execute();
                $affectedRows = $stmt->affected_rows;
                $stmt->close();

                // Debug: Log update result
                error_log("updateBug: bug_id=$bugId updated, affected_rows=$affectedRows");

                // Update or insert bug_staff (for admin/staff only)
                if ($_SESSION['userRole'] != 'customer' && $assignedTo !== null && $assignedTo > 0) {
                    // Check if bug_staff record exists
                    $checkBugStaffQuery = "SELECT * FROM bug_staff WHERE bug_id = ?";
                    $stmt = $conn->prepare($checkBugStaffQuery);
                    $stmt->bind_param("i", $bugId);
                    $stmt->execute();
                    $bugStaffExists = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $stmt->close();

                    if ($bugStaffExists) {
                        // Update existing bug_staff record
                        $query_bug_staff = "UPDATE bug_staff SET staff_id = ? WHERE bug_id = ?";
                        $stmt = $conn->prepare($query_bug_staff);
                        $stmt->bind_param("ii", $assignedTo, $bugId);
                    } else {
                        // Insert new bug_staff record
                        $query_bug_staff = "INSERT INTO bug_staff (bug_id, staff_id) VALUES (?, ?)";
                        $stmt = $conn->prepare($query_bug_staff);
                        $stmt->bind_param("ii", $bugId, $assignedTo);
                    }
                    $stmt->execute();
                    $stmt->close();

                    // Debug: Log bug_staff update/insert
                    error_log("updateBug: bug_staff updated/inserted for bug_id=$bugId, staff_id=$assignedTo");
                } elseif ($_SESSION['userRole'] != 'customer' && $assignedTo === null) {
                    // If assigned_to is null, remove bug_staff record if exists
                    $deleteBugStaffQuery = "DELETE FROM bug_staff WHERE bug_id = ?";
                    $stmt = $conn->prepare($deleteBugStaffQuery);
                    $stmt->bind_param("i", $bugId);
                    $stmt->execute();
                    $stmt->close();

                    // Debug: Log bug_staff deletion
                    error_log("updateBug: bug_staff deleted for bug_id=$bugId");
                }

                // Commit transaction
                $conn->commit();
                $this->db->closeConnection();

                $_SESSION["successMsg"] = "Bug updated successfully.";
                return true;
            } catch (Exception $e) {
                // Rollback transaction on error
                $conn->rollback();
                $this->db->closeConnection();

                // Debug: Log error
                error_log("updateBug: Error - " . $e->getMessage());

                $_SESSION["errMsg"] = "Failed to update bug: " . $e->getMessage();
                return false;
            }
        } else {
            $_SESSION["errMsg"] = "Database connection error.";
            return false;
        }
    }


}

?>