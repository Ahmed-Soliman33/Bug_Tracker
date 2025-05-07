<?php

require_once '../../Models/Staff.php';
require_once '../../Models/Chat.php';
require_once '../../Controllers/DBController.php';

class ChatController
{
    protected $db;



    public function createChat($userId_1, $userId_2)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "INSERT INTO chats () VALUES ()";

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