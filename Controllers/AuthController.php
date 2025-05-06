<?php

require_once '../../Models/user.php';
require_once '../../Controllers/DBController.php';
class AuthController
{
    protected $db;


    public function login(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * from users where email='$user->email' and password ='$user->password'";
            $result = $this->db->select($query);
            if ($result === false) {
                echo "Error in Query";
                return false;
            } else {
                if (count($result) == 0) {
                    // session_start();
                    $_SESSION["errMsg"] = "You have entered wrong email or password";
                    $this->db->closeConnection();
                    return false;
                } else {
                    // session_start();
                    $_SESSION["userId"] = $result[0]["id"];
                    $_SESSION["userName"] = $result[0]["name"];
                    $_SESSION["userRole"] = $result[0]["role"];


                    $this->db->closeConnection();
                    return true;
                }
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }
    public function register(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $stmt = "INSERT INTO users (name, email, password, role) VALUES ('$user->name','$user->email','$user->password' , '$user->role')";
            $result = $this->db->insert($stmt);
            if ($result != false) {
                session_start();
                $_SESSION["userId"] = $result;
                $_SESSION["userName"] = $user->name;
                $_SESSION["userRole"] = "customer";
                $this->db->closeConnection();
                return true;
            } else {
                $_SESSION["errMsg"] = "Somthing went wrong... try again later";
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