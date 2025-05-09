<?php
require_once '../Models/Message.php';
require_once 'DBController.php';

class MessageController
{
    protected $db;

    public function sendMessage(Message $message, $user_role)
    {
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            // Validate access
            $query = "SELECT * FROM bugs WHERE id = ?";
            if ($user_role == 'customer') {
                $query .= " AND customer_id = ?";
            } elseif ($user_role == 'staff') {
                $query .= " AND id IN (SELECT bug_id FROM assigned_bugs WHERE staff_id = ?)";
            }
            $stmt = $this->db->prepare($query);
            if ($user_role == 'admin') {
                $stmt->bind_param("i", $message->getBugId());
            } else {
                $stmt->bind_param("ii", $message->getBugId(), $message->getUserId());
            }
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            if (count($result) == 0) {
                $_SESSION["errMsg"] = "You are not authorized to send messages for this bug.";
                $this->db->closeConnection();
                return false;
            }

            // Insert message
            $query = "INSERT INTO messages (bug_id, sender_id, message, sent_at) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iiss", $message->getBugId(), $message->getUserId(), $message->getContent(), $message->getSentAt());
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
            $_SESSION["errMsg"] = "Error in Database Connection";
            return false;
        }
    }

    public function getChatMessages($bug_id, $user_id, $user_role)
    {
        $this->db = new DBController();
        if ($this->db->openConnection()) {
            $query = "SELECT m.*, u.name AS sender_name 
                      FROM messages m 
                      JOIN users u ON m.sender_id = u.id 
                      WHERE m.bug_id = ?";
            if ($user_role == 'customer') {
                $query .= " AND (m.sender_id = ? OR m.sender_id IN (SELECT id FROM users WHERE role IN ('admin', 'staff')))";
            }
            $query .= " ORDER BY m.sent_at ASC";

            $stmt = $this->db->prepare($query);
            if ($user_role == 'customer') {
                $stmt->bind_param("ii", $bug_id, $user_id);
            } else {
                $stmt->bind_param("i", $bug_id);
            }
            $stmt->execute();
            $messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            $this->db->closeConnection();
            return $messages;
        } else {
            $_SESSION["errMsg"] = "Error in Database Connection";
            return false;
        }
    }
}
?>