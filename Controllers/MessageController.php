<?php
require_once '../../Models/Message.php';
require_once '../../Controllers/DBController.php';
require_once '../../Controllers/AuthController.php';
require_once '../../Controllers/StaffController.php';
require_once '../../Controllers/CustomerController.php';

class MessageController
{
    protected $db;

    public function sendMessage(Message $message, $user_role)
    {
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            $bug_id = $message->getBugId();
            $sender_id = $message->getUserId();

            error_log("sendMessage: bug_id=$bug_id, sender_id=$sender_id, user_role=$user_role");

            $query = "SELECT b.id FROM bugs b";
            if ($user_role == 'customer') {
                $authController = new AuthController();
                $user = $authController->getUserById($sender_id);
                if (!$user) {
                    $_SESSION["errMsg"] = "User not found.";
                    $this->db->closeConnection();
                    return false;
                }
                $customerController = new CustomerController();
                $customer = $customerController->getCustomerByEmail($user[0]["email"]);
                if (!$customer) {
                    $_SESSION["errMsg"] = "Customer not found.";
                    $this->db->closeConnection();
                    return false;
                }
                $customer_id = $customer[0]["customer_id"];

                error_log("sendMessage: customer_id=$customer_id");

                $query .= " INNER JOIN bug_customer bc ON b.id = bc.bug_id WHERE b.id = ? AND bc.customer_id = ?";
            } elseif ($user_role == 'staff') {
                $authController = new AuthController();
                $user = $authController->getUserById($sender_id);
                if (!$user) {
                    $_SESSION["errMsg"] = "User not found.";
                    $this->db->closeConnection();
                    return false;
                }
                $staffController = new StaffController();
                $staff = $staffController->getStaffByEmail($user[0]["email"]);
                if (!$staff) {
                    $_SESSION["errMsg"] = "Staff not found.";
                    $this->db->closeConnection();
                    return false;
                }
                $staff_id = $staff[0]["staff_id"];

                error_log("sendMessage: staff_id=$staff_id");

                $query .= " INNER JOIN bug_staff bs ON b.id = bs.bug_id WHERE b.id = ? AND bs.staff_id = ?";
            } else {
                $query .= " WHERE b.id = ?";
            }
            $stmt = $this->db->connection->prepare($query);

            if ($user_role == 'admin') {
                $stmt->bind_param("i", $bug_id);
            } elseif ($user_role == 'staff') {
                $stmt->bind_param("ii", $bug_id, $staff_id);
            } else {
                $stmt->bind_param("ii", $bug_id, $customer_id);
            }
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            error_log("sendMessage: Bug validation result=" . json_encode($result));

            if (count($result) == 0) {
                $_SESSION["errMsg"] = "Not authorized to send messages for this bug.";
                $this->db->closeConnection();
                return false;
            }

            $recipient_id = $message->getRecipientId();
            $query = "SELECT id FROM users WHERE id = ? AND role IN ('admin', 'staff', 'customer')";
            $stmt = $this->db->connection->prepare($query);
            $stmt->bind_param("i", $recipient_id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            if (count($result) == 0) {
                $_SESSION["errMsg"] = "Invalid recipient.";
                $this->db->closeConnection();
                return false;
            }

            $query = "INSERT INTO messages (bug_id, sender_id, recipient_id, message, sent_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->connection->prepare($query);
            $content = $message->getContent();
            $sent_at = $message->getSentAt();
            $stmt->bind_param("iiiss", $bug_id, $sender_id, $recipient_id, $content, $sent_at);
            $result = $stmt->execute();
            $messageId = $result ? $this->db->connection->insert_id : false;
            $stmt->close();
            $this->db->closeConnection();

            if ($messageId) {
                $message->setId($messageId);
                return true;
            }
            $_SESSION["errMsg"] = "Failed to send message.";
            return false;
        } else {
            $_SESSION["errMsg"] = "Database connection error.";
            return false;
        }
    }

    public function getUserMessages($user_id, $user_role)
    {
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            $query = "SELECT m.*, u.name AS sender_name, b.bug_name 
                      FROM messages m 
                      JOIN users u ON m.sender_id = u.id 
                      JOIN bugs b ON m.bug_id = b.id 
                      WHERE m.recipient_id = ?";
            if ($user_role == 'customer') {
                $authController = new AuthController();
                $user = $authController->getUserById($user_id);
                if (!$user) {
                    $_SESSION["errMsg"] = "User not found.";
                    return [];
                }
                $customerController = new CustomerController();
                $customer = $customerController->getCustomerByEmail($user[0]["email"]);
                if (!$customer) {
                    $_SESSION["errMsg"] = "Customer not found.";
                    return [];
                }
                $customer_id = $customer[0]["customer_id"];

                $query .= " AND m.bug_id IN (SELECT bug_id FROM bug_customer WHERE customer_id = ?)";
            } elseif ($user_role == 'staff') {
                $authController = new AuthController();
                $user = $authController->getUserById($user_id);
                if (!$user) {
                    $_SESSION["errMsg"] = "User not found.";
                    return [];
                }
                $staffController = new StaffController();
                $staff = $staffController->getStaffByEmail($user[0]["email"]);
                if (!$staff) {
                    $_SESSION["errMsg"] = "Staff not found.";
                    return [];
                }
                $staff_id = $staff[0]["staff_id"];

                $query .= " AND m.bug_id IN (SELECT bug_id FROM bug_staff WHERE staff_id = ?)";
            }
            $query .= " ORDER BY m.sent_at DESC";

            $stmt = $this->db->connection->prepare($query);
            if ($user_role == 'admin') {
                $stmt->bind_param("i", $user_id);
            } else {
                if ($user_role == 'customer') {

                    $stmt->bind_param("ii", $user_id, $customer_id);
                } else {
                    $stmt->bind_param("ii", $user_id, $staff_id);
                }
            }
            $stmt->execute();
            $messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            $this->db->closeConnection();

            error_log("Fetched messages for user_id=$user_id, role=$user_role: " . json_encode($messages));

            return $messages;
        } else {
            $_SESSION["errMsg"] = "Database connection error.";
            return [];
        }
    }
}
?>