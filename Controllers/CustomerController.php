<?php
require_once '../../Models/Customer.php';
require_once '../../Controllers/DBController.php';

class CustomerController
{
    protected $db;

    public function addCustomer(Customer $customer)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $checkQuery = "SELECT * FROM users WHERE email = '$customer->email'";
            $result = $this->db->select($checkQuery);

            if (!empty($result)) {
                $this->db->closeConnection();
                return false;
            }

            $usersQuery = "INSERT INTO users (name, email, password, role) 
                           VALUES ('$customer->name','$customer->email','$customer->password','$customer->role')";

            $customerQuery = "INSERT INTO customers (customer_name, customer_email) 
                              VALUES ('$customer->name','$customer->email')";

            $usersResult = $this->db->insert($usersQuery);
            $customerResult = $this->db->insert($customerQuery);

            $this->db->closeConnection();
            return ($usersResult && $customerResult) ? true : false;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function getAllCustomers()
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT * FROM customer";
            $result = $this->db->select($query);
            $this->db->closeConnection();
            return $result ? $result : false;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function getCustomerByEmail($email)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT * FROM users WHERE email = '$email' AND role = 'customer'";
            $result = $this->db->select($query);
            $this->db->closeConnection();
            return $result ? $result : false;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }
    

    public function deleteCustomer($customerId, $customerEmail)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query_bug = "DELETE FROM bug_customer WHERE customer_id = $customerId";
            $query_users = "DELETE FROM users WHERE email = '$customerEmail'";
            $query = "DELETE FROM customers WHERE customer_id = $customerId";

            $result_bug = $this->db->delete($query_bug);
            $result_users = $this->db->delete($query_users);
            $result = $this->db->delete($query);

            $this->db->closeConnection();
            return ($result && $result_bug && $result_users) ? true : false;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }
}



























?>