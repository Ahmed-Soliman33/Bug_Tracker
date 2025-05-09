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
                    $_SESSION["errMsg"] = "You have entered wrong email or password";
                    $this->db->closeConnection();
                    return false;
                } else {
                    if ($result[0]["role"] == "staff") {
                        $_SESSION["userId"] = $result[0]["id"];
                        $_SESSION["userName"] = $result[0]["name"];
                        $_SESSION["userRole"] = $result[0]["role"];
                    } else {
                        $_SESSION["userId"] = $result[0]["id"];
                        $_SESSION["userName"] = $result[0]["name"];
                        $_SESSION["userRole"] = $result[0]["role"];
                    }
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

            $checkQuery = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->db->connection->prepare($checkQuery);
            $stmt->bind_param("s", $user->email);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            if (count($result) > 0) {

                $_SESSION["errMsg"] = "Email already exists. Please use a different email.";
                $this->db->closeConnection();
                return false;
            }

            $insertUsers = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->connection->prepare($insertUsers);
            $stmt->bind_param("ssss", $user->name, $user->email, $user->password, $user->role);
            $result_users = $stmt->execute();
            if ($result_users) {
                $insertCustomer = "INSERT INTO customer (customer_name, customer_email) VALUES (?, ?)";
                $stmt = $this->db->connection->prepare($insertCustomer);
                $stmt->bind_param("ssss", $user->name, $user->email);
                $result_customer = $stmt->execute();
                if ($result_customer) {
                    $_SESSION["userId"] = $this->db->connection->insert_id;
                    $_SESSION["userName"] = $user->name;
                    $_SESSION["userRole"] = $user->role;
                    $stmt->close();
                    $this->db->closeConnection();
                    return true;
                } else {
                    $_SESSION["errMsg"] = "Something went wrong... try again later.";
                    $stmt->close();
                    $this->db->closeConnection();
                    return false;
                }
            }

        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * from users where id = $id";
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