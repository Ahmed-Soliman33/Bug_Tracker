<?php

require_once '../../Models/Message.php';
require_once '../../Models/Chat.php';
require_once '../../Controllers/DBController.php';

class MessageController
{
    protected $db;


    public function sendMessage(Message $message)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $chat_id = $message->getChatId();
            $user_id = $message->getUserId();
            $content = $message->getContent();
            $query = "INSERT INTO messages (chat_id, user_id, content) VALUES ($chat_id, $user_id, '$content')";
            $result = $this->db->insert($query);
            if ($result) {
                $message->setId($result);
                $this->db->update("UPDATE chats SET updated_at = NOW() WHERE id = $chat_id");
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

    public function getChatMessages($userId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT 
                        m.id,
                        m.chat_id,
                        m.user_id,
                        m.content,
                        m.sent_at,
                        u.name AS sender_name
                      FROM 
                        messages m
                      JOIN 
                        users u ON m.user_id = u.id
                      WHERE 
                        m.chat_id = ?
                      ORDER BY 
                        m.sent_at ASC";

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
    public function getChatParticipants($chatId)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "SELECT 
                        u.id,
                        u.name
                      FROM 
                        chat_user cu
                      JOIN 
                        users u ON cu.user_id = u.id
                      WHERE 
                        cu.chat_id = $chatId";
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