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
            $usersQuery = "INSERT INTO users (name, email, password, role) VALUES ('$staff->name','$staff->email','$staff->password','$staff->role')";
            $staffQuery = "INSERT INTO staff (staff_name, staff_email) VALUES ('$staff->name','$staff->email')";

            $usersResult = $this->db->insert($usersQuery);
            $staffResult = $this->db->insert($staffQuery);
            if ($usersResult && $staffResult) {
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


}

?>