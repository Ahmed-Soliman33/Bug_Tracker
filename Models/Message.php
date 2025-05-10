<?php
class Message
{
    private $id;
    private $bug_id;
    private $sender_id;
    private $recipient_id; // New field
    private $content;
    private $sent_at;

    public function __construct($id, $bug_id, $sender_id, $content, $sent_at = null)
    {
        $this->id = $id;
        $this->bug_id = $bug_id;
        $this->sender_id = $sender_id;
        $this->content = $content;
        $this->sent_at = $sent_at ?? date('Y-m-d H:i:s');
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getBugId()
    {
        return $this->bug_id;
    }
    public function getUserId()
    {
        return $this->sender_id;
    }
    public function getRecipientId()
    {
        return $this->recipient_id;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getSentAt()
    {
        return $this->sent_at;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setRecipientId($recipient_id)
    {
        $this->recipient_id = $recipient_id;
    }
}
?>