<?php

require_once '../../Models/Staff.php';
require_once '../../Controllers/DBController.php';

class StaffController
{
    protected $db;


    public function addStaff(Staff $staff)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $checkQuery = "SELECT * FROM users WHERE email = '$staff->email'";
            $result = $this->db->select($checkQuery);

            if (!empty($result)) {
                $this->db->closeConnection();
                return false;
            }

            $usersQuery = "INSERT INTO users (name, email, password, role) VALUES ('$staff->name','$staff->email','$staff->password','$staff->role')";
            $staffQuery = "INSERT INTO staff (staff_name, staff_email) VALUES ('$staff->name','$staff->email')";

            $usersResult = $this->db->insert($usersQuery);
            $staffResult = $this->db->insert($staffQuery);

            $this->db->closeConnection();
            return ($usersResult && $staffResult) ? true : false;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function getAllStaff()
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * from staff";

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
    public function getStaffByEmail($email)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * from staff where staff_email = '$email'";
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


    public function deleteStaff($staffId, $staffEmail)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query_bug = "DELETE FROM bug_staff WHERE staff_id = $staffId";
            $query_users = "DELETE FROM users WHERE email = '$staffEmail'";
            $query = "DELETE FROM staff WHERE staff_id = $staffId";

            $result_bug = $this->db->delete($query_bug);
            $result_users = $this->db->delete($query_users);
            $result = $this->db->delete($query);

            if ($result && $result_bug && $result_users) {
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