<?php
class Message
{
    private $id;
    private $bugId;
    private $userId;
    private $content;
    private $sentAt;

    public function __construct($id = 0, $bugId = 0, $userId = 0, $content = '', $sentAt = null)
    {
        $this->id = $id;
        $this->bugId = $bugId;
        $this->userId = $userId;
        $this->content = $content;
        $this->sentAt = $sentAt ?? date('Y-m-d H:i:s');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getBugId()
    {
        return $this->bugId;
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

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setBugId($bugId)
    {
        $this->bugId = $bugId;
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