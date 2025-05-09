<?php
class Chat
{
    private $bugId;
    public $messages; // Made public for simplicity in view access

    public function __construct($bugId = 0, $messages = [])
    {
        $this->bugId = $bugId;
        $this->messages = $messages;
    }

    public function getBugId()
    {
        return $this->bugId;
    }
    public function getMessages()
    {
        return $this->messages;
    }

    public function setBugId($bugId)
    {
        $this->bugId = $bugId;
    }
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }
}
?>