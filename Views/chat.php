<?php
require_once '../Controllers/ChatController.php';
require_once '../Controllers/MessageController.php';
require_once '../Models/Message.php';
require_once '../Controllers/DBController.php';

$bug_id = $_GET['bug_id'] ?? null;
$user_id = $_SESSION['userId'] ?? null;
$user_role = $_SESSION['userRole'] ?? null;
$errMsg = $_SESSION['errMsg'] ?? '';
$successMsg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $bug_id && $user_id && $user_role) {
    $message_text = $_POST['message'] ?? null;
    $recipient_id = $_POST['recipient_id'] ?? null; // Only for admins

    if ($message_text) {
        $message = new Message(0, $bug_id, $user_id, $message_text);
        $messageController = new MessageController();
        if ($messageController->sendMessage($message, $user_role)) {
            $successMsg = "Message sent successfully.";
        } else {
            $errMsg = $_SESSION['errMsg'] ?? "Failed to send message.";
        }
        unset($_SESSION['errMsg']);
    } else {
        $errMsg = "Message content is required.";
    }
}

// Load chat messages
if ($bug_id && $user_id && $user_role) {
    $chatController = new ChatController();
    $chat = $chatController->getChat($bug_id, $user_id, $user_role);
} else {
    $errMsg = $errMsg ?: "Invalid session or bug ID. Please log in or select a valid bug.";
    $chat = new Chat($bug_id, []);
}
?>

<div class="col-md-10 mx-auto">
    <div class="card direct-chat direct-chat-warning">
        <div class="card-header">
            <h3 class="card-title">Chat for Bug #<?php echo htmlspecialchars($bug_id ?? 'N/A'); ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#chat-body">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>
        <div class="card-body collapse show" id="chat-body">
            <div class="direct-chat-messages" style="max-height: 400px; overflow-y: auto;" id="chat-box">
                <?php if ($errMsg): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($errMsg); ?></div>
                <?php endif; ?>
                <?php if ($successMsg): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($successMsg); ?></div>
                <?php endif; ?>
                <?php if (empty($chat->messages)): ?>
                    <p class="text-muted text-center">No messages yet.</p>
                <?php else: ?>
                    <?php foreach ($chat->messages as $msg): ?>
                        <div class="direct-chat-msg <?php echo $msg['sender_id'] == $user_id ? 'end' : ''; ?>">
                            <div class="direct-chat-infos clearfix">
                                <span
                                    class="direct-chat-name <?php echo $msg['sender_id'] == $user_id ? 'float-end' : 'float-start'; ?>">
                                    <?php echo htmlspecialchars($msg['sender_name'] ?? 'Unknown'); ?>
                                </span>
                                <span
                                    class="direct-chat-timestamp <?php echo $msg['sender_id'] == $user_id ? 'float-start' : 'float-end'; ?>">
                                    <?php echo htmlspecialchars($msg['sent_at'] ?? ''); ?>
                                </span>
                            </div>
                            <img class="direct-chat-img"
                                src="../assets/img/<?php echo $msg['sender_id'] == $user_id ? 'user3-128x128.jpg' : 'user1-128x128.jpg'; ?>"
                                alt="user image">
                            <div class="direct-chat-text">
                                <?php echo htmlspecialchars($msg['message'] ?? ''); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer">
            <?php if ($bug_id && $user_id && $user_role): ?>
                <form id="chat-form" action="" method="POST">
                    <input type="hidden" name="bug_id" value="<?php echo htmlspecialchars($bug_id); ?>">
                    <input type="hidden" name="sender_id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <div class="input-group">
                        <?php if ($user_role == 'admin'): ?>
                            <select name="recipient_id" class="form-select" required>
                                <option value="">Select Recipient</option>
                                <?php
                                $db = new DBController();
                                if ($db->openConnection()) {
                                    $query = "SELECT id, name FROM users WHERE id != ? AND role IN ('admin', 'staff', 'customer')";
                                    $stmt = $db->prepare($query);
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                    foreach ($users as $user) {
                                        echo "<option value='{$user['id']}'>" . htmlspecialchars($user['name']) . "</option>";
                                    }
                                    $stmt->close();
                                    $db->closeConnection();
                                }
                                ?>
                            </select>
                        <?php endif; ?>
                        <input name="message" type="text" placeholder="Type Message..." class="form-control" required>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-warning">Send</button>
                        </span>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-muted">Please log in to send messages.</p>
            <?php endif; ?>
        </div>
    </div>
</div>