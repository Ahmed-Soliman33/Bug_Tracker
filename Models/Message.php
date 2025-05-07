<?php
class Message
{
    private $id;
    private $chatId;
    private $userId;
    private $content;
    private $sentAt;

    public function __construct($id = 0, $chatId = 0, $userId = 0, $content = '', $sentAt = null)
    {
        $this->id = $id;
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->content = $content;
        $this->sentAt = $sentAt ?? date('Y-m-d H:i:s');
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getChatId()
    {
        return $this->chatId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getSentAt()
    {
        return $this->sentAt;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setChatId($chatId)
    {
        $this->chatId = $chatId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
    }
}
?>