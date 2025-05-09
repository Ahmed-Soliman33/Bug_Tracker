<?php
require_once '../Models/Chat.php';
require_once 'MessageController.php';

class ChatController
{
    public function getChat($bug_id, $user_id, $user_role)
    {
        $messageController = new MessageController();
        $messages = $messageController->getChatMessages($bug_id, $user_id, $user_role);
        return new Chat($bug_id, $messages); // $messages is always an array
    }
}
?>